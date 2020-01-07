## Netwerken en Systeembeveiliging Lab 5 - Distributed Sensor Network
## NAME:
## STUDENT ID:
import sys
import struct
from socket import *
from random import randint
from gui import MainWindow
from sensor import *
import select
import math
import threading

neighbor_list = []

def threaded_ping(*args, **kwargs):
    try:
        args[0].sendto(message_encode(MSG_PING, 0, args[1], (0, 0), 0, args[2], 0), mcast_addr)
        print "Ping sent"
    except:
        pass
    threading.Timer(2.0, threaded_ping, args).start()

def print_neighbors():
    printvalue = ""
    for i in neighbor_list:
        printvalue += str(i)
    return printvalue

# Get random position in NxN grid.
def random_position(n):
    x = randint(0, n)
    y = randint(0, n)
    return (x, y)


def calc_neighbor(own_pos, neighbor_pos):
    x = math.pow(math.fabs(own_pos[0] - neighbor_pos[0]), 2)
    y = math.pow(math.fabs(own_pos[1] - neighbor_pos[1]), 2)
    z = math.sqrt((x + y))
    return z

def add_neighbor(neighbor_pos, sensor_range, sensor_pos, address):
    if (address, neighbor_pos) not in neighbor_list:
        distance = calc_neighbor(sensor_pos, neighbor_pos)
        if sensor_range >= distance:
            neighbor_list.append((address, neighbor_pos))


def main(mcast_addr,
         sensor_pos, sensor_range, sensor_val,
         grid_size, ping_period):
    """
    mcast_addr: udp multicast (ip, port) tuple.
    sensor_pos: (x,y) sensor position tuple.
    sensor_range: range of the sensor ping (radius).
    sensor_val: sensor value.
    grid_size: length of the  of the grid (which is always square).
    ping_period: time in seconds between multicast pings.
    """
    sequence = 0
    echos = {}

    # -- Create the multicast listener socket. --
    mcast = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP)
    # Sets the socket address as reusable so you can run multiple instances
    # of the program on the same machine at the same time.
    mcast.setsockopt(SOL_SOCKET, SO_REUSEADDR, 1)
    # Subscribe the socket to multicast messages from the given address.
    mreq = struct.pack('4sl', inet_aton(mcast_addr[0]), INADDR_ANY)
    mcast.setsockopt(IPPROTO_IP, IP_ADD_MEMBERSHIP, mreq)
    if sys.platform == 'win32': # windows special case
        mcast.bind( ('localhost', mcast_addr[1]) )
    else: # should work for everything else
        mcast.bind(mcast_addr)

    # -- Create the peer-to-peer socket. --
    peer = socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP)
    # Set the socket multicast TTL so it can send multicast messages.
    peer.setsockopt(IPPROTO_IP, IP_MULTICAST_TTL, 5)
    # Bind the socket to a random port.
    if sys.platform == 'win32': # windows special case
        peer.bind( ('localhost', INADDR_ANY) )
    else: # should work for everything else
        peer.bind( ('', INADDR_ANY) )

    # -- make the gui --
    window = MainWindow()
    window.writeln( 'my address is %s:%s' % peer.getsockname() )
    window.writeln( 'my position is (%s, %s)' % sensor_pos )
    window.writeln( 'my sensor value is %s' % sensor_val )

    threading.Timer(0.25, threaded_ping, [peer, sensor_pos, sensor_range]).start()

    # -- This is the event loop. --
    while window.update():
        line = window.getline()
        if line:
            window.writeln(line)
            if line.startswith("ping"):
                del neighbor_list[:]
                peer.sendto(message_encode(MSG_PING, 0, sensor_pos, (0, 0), 0, sensor_range, 0), mcast_addr)
            elif line.startswith("list"):
                window.writeln(print_neighbors())
            elif line.startswith("move"):
                window.writeln("Old position: " + str(sensor_pos))
                sensor_pos = random_position(grid_size)
                window.writeln("New position: " + str(sensor_pos))
            elif line.startswith("set"):
                value = int(line.split()[1])
                if 19 < value < 71:
                    window.writeln("Old range: " + str(sensor_range))
                    sensor_range = value
                    window.writeln("New range: " + str(sensor_range))
            elif line.startswith("echo"):
                echo_id = (sequence, sensor_pos)
                echos[echo_id] = [0, peer.getsockname()]
                if neighbor_list:
                    for neighbor in neighbor_list:
                        echos[echo_id][0] += 1
                        peer.sendto(message_encode(MSG_ECHO, sequence, sensor_pos, neighbor[1], OP_NOOP, sensor_range, 0), mcast_addr)
                sequence += 1

        socket_list = [sys.stdin, mcast, peer]
        ready_to_read, ready_to_write, in_error = select.select(socket_list , [], [], 0)
        for sock in ready_to_read:
            data, address = sock.recvfrom(2048)
            if data and peer.getsockname()[1] != address[1]:
                decoded = []
                for i in message_decode(data):
                    decoded.append(i)

                distance = calc_neighbor(sensor_pos, decoded[2])

                if sensor_range >= distance:
                    if decoded[0] == MSG_PING:
                        decoded[0] = MSG_PONG
                        decoded[3] = sensor_pos
                        peer.sendto(message_encode(decoded[0], decoded[1], decoded[2], decoded[3], decoded[4], decoded[5], decoded[6]), address)
                    elif decoded[0] == MSG_PONG:
                        add_neighbor(decoded[3], sensor_range, sensor_pos, address)
                    elif decoded[0] == MSG_ECHO:
                        echo_id = (decoded[1], decoded[2])
                        if neighbor_list and echo_id not in echos:
                            print("HOI")
                            echos[echo_id] = [0, address]
                            for neighbor in neighbor_list:
                                print("Hallo")
                                if neighbor[0] != address:
                                    print("HELLO")
                                    echos[echo_id][0] += 1
                                    window.writeln("Echo\n")
                                    peer.sendto(message_encode(MSG_ECHO, decoded[1], decoded[2], neighbor[1], OP_NOOP, sensor_val, 0), neighbor[0])
                        else:
                            peer.sendto(message_encode(MSG_ECHO_REPLY, decoded[1], decoded[2], (0, 0), OP_NOOP, sensor_val, 0), address)
                    elif decoded[0] == MSG_ECHO_REPLY:
                        echo_id = (decoded[1], decoded[2])
                        if decoded[2] == sensor_pos:
                            window.writeln("Echo completed\n")
                        elif echos[echo_id][0] == 0:
                            window.writeln("Got echo back from all children\n")
                            peer.sendto(message_encode(MSG_ECHO_REPLY, decoded[1], decoded[2], neighbor[1], OP_NOOP, sensor_val, 0), echos[echo_id][1])
                        else:
                            window.writeln("Echo received back\n")
                            echos[echo_id][0] = echos[echo_id] - 1

# -- program entry point --
if __name__ == '__main__':
    import sys, argparse
    p = argparse.ArgumentParser()
    p.add_argument('--group', help='multicast group', default='224.1.1.1')
    p.add_argument('--port', help='multicast port', default=15684, type=int)
    p.add_argument('--pos', help='x,y sensor position', default=None)
    p.add_argument('--grid', help='size of grid', default=100, type=int)
    p.add_argument('--range', help='sensor range', default=50, type=int)
    p.add_argument('--value', help='sensor value', default=-1, type=int)
    p.add_argument('--period', help='period between autopings (0=off)',
                   default=5, type=int)
    args = p.parse_args(sys.argv[1:])
    if args.pos:
        pos = tuple( int(n) for n in args.pos.split(',')[:2] )
    else:
        pos = random_position(args.grid)
    if args.value >= 0:
        value = args.value
    else:
        value = randint(0, 100)
    mcast_addr = (args.group, args.port)
    main(mcast_addr, pos, args.range, value, args.grid, args.period)
