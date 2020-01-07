## Netwerken en Systeembeveiliging Lab 5 - Distributed Sensor Network
## NAME: Sander Hansen; Baran Erdogan
## STUDENT ID: 10995080; 11008008
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

def interval_ping(peer, sensor_pos, sensor_range, ping_period):
	del neighbor_list[:]
	peer.sendto(message_encode(MSG_PING, 0, sensor_pos, sensor_pos, 0,
				sensor_range, 0), mcast_addr)
	print("Ping sent")
	global thread
	thread = threading.Timer(ping_period, interval_ping, [peer, sensor_pos,
							 sensor_range, ping_period])
	thread.start()


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

	if ping_period != 0:
		interval_ping(peer, sensor_pos, sensor_range, ping_period)

	# -- This is the event loop. --
	while window.update():
		line = window.getline()
		if line:
			window.writeln(line)
			if line.startswith("ping"):
				del neighbor_list[:]
				peer.sendto(message_encode(MSG_PING, 0, sensor_pos, sensor_pos,
							0, sensor_range, 0), mcast_addr)
			elif line.startswith("list"):
				window.writeln(print_neighbors())
			elif line.startswith("move"):
				sensor_pos = random_position(grid_size)
			elif line.startswith("set"):
				value = int(line.split()[1])
				if value == 20 or value == 30 or value == 40 or value == 50 \
				   or value == 60 or value == 70:
					sensor_range = value
					window.writeln("Range changed to: " + str(sensor_range))
				else:
					window.writeln("Range not allowed, it can be in the range"
									+ "of 20 until 70 with an increment of 10")
			elif line.startswith("value"):
				sensor_val = randint(0, 100)
				window.writln("Sensor value has been changed to: "
							  + str(sensor_val))
			elif line.startswith("echo") or line.startswith("size") \
				 or line.startswith("sum") or line.startswith("min") \
				 or line.startswith("max") or line.startswith("same"):
				echo_id = (sequence, sensor_pos)
				echos[echo_id] = [0, peer.getsockname(), 0, 0]
				if neighbor_list:
					for neighbor in neighbor_list:
						echos[echo_id][0] += 1
						if line.startswith("size"):
							peer.sendto(message_encode(MSG_ECHO, sequence,
										sensor_pos, sensor_pos, OP_SIZE,
										sensor_range, 0), neighbor[0])
						elif line.startswith("sum"):
							peer.sendto(message_encode(MSG_ECHO, sequence,
										sensor_pos, sensor_pos, OP_SUM,
										sensor_range, 0), neighbor[0])
						elif line.startswith("min"):
							peer.sendto(message_encode(MSG_ECHO, sequence,
										sensor_pos, sensor_pos, OP_MIN,
										sensor_range, 0), neighbor[0])
						elif line.startswith("max"):
							peer.sendto(message_encode(MSG_ECHO, sequence,
										sensor_pos, sensor_pos, OP_MAX,
										sensor_range, 0), neighbor[0])
						elif line.startswith("same"):
							peer.sendto(message_encode(MSG_ECHO, sequence,
										sensor_pos, sensor_pos, OP_SAME,
										sensor_range, sensor_val), neighbor[0])
						else:
							peer.sendto(message_encode(MSG_ECHO, sequence,
										sensor_pos, sensor_pos, OP_NOOP,
										sensor_range, 0), neighbor[0])
					sequence += 1
				else:
					if line.startswith("size"):
						window.writeln("Size of network is: 1")
					elif line.startswith("sum"):
						window.writeln("The sum of the sensor values is: "
									   + str(sensor_val))
					elif line.startswith("min"):
						window.writeln("The minimum sensor value is: "
									   + str(sensor_val))
					elif line.startswith("max"):
						window.writeln("The maximum sensor value is: "
									   + str(sensor_val))
					elif line.startswith("same"):
						window.writeln("The amount of other sensors that have"
									   + "the same value is: 0")
					else:
						window.writeln("Echo complete")

		socket_list = [sys.stdin, mcast, peer]
		ready_to_read, ready_to_write, in_error = select.select(socket_list ,
																[], [], 0)
		for sock in ready_to_read:
			data, address = sock.recvfrom(2048)
			if data and peer.getsockname()[1] != address[1]:
					decoded = []
					for i in message_decode(data):
						decoded.append(i)

					distance = calc_neighbor(sensor_pos, decoded[3])

					if sensor_range >= distance:
						if decoded[0] == MSG_PING:
							decoded[0] = MSG_PONG
							decoded[3] = sensor_pos
							peer.sendto(message_encode(decoded[0], decoded[1],
										decoded[2], sensor_pos, decoded[4],
										decoded[5], decoded[6]), address)
							window.writeln("Ping received\n")
						elif decoded[0] == MSG_PONG:
							add_neighbor(decoded[3], sensor_range, sensor_pos,
										 address)
							window.writeln("Pong received\n")
						elif decoded[0] == MSG_ECHO:
							echo_id = (decoded[1], decoded[2])
							if neighbor_list and not echos.has_key(echo_id):
								echos[echo_id] = [0, address, 0, decoded[6]]
								for neighbor in neighbor_list:
									if neighbor[0] != address:
										echos[echo_id][0] += 1
										#window.writeln("Echo_send\n")
										if decoded[4] == OP_SIZE:
											peer.sendto(message_encode(
											MSG_ECHO, decoded[1], decoded[2],
											sensor_pos, OP_SIZE, decoded[5],
											0), neighbor[0])
										elif decoded[4] == OP_SUM:
											peer.sendto(message_encode(
											MSG_ECHO, decoded[1], decoded[2],
											sensor_pos, OP_SUM, decoded[5], 0),
											neighbor[0])
										elif decoded[4] == OP_MIN:
											peer.sendto(message_encode(
											MSG_ECHO, decoded[1], decoded[2],
										 	sensor_pos, OP_MIN, decoded[5], 0),
											neighbor[0])
										elif decoded[4] == OP_MAX:
											peer.sendto(message_encode(
											MSG_ECHO, decoded[1], decoded[2],
											sensor_pos, OP_MAX, decoded[5], 0),
											neighbor[0])
										elif decoded[4] == OP_SAME:
											peer.sendto(message_encode(
											MSG_ECHO, decoded[1], decoded[2],
											sensor_pos, OP_SAME, decoded[5],
											decoded[6]), neighbor[0])
										else:
											window.writeln("Echo\n")
											peer.sendto(message_encode(
											MSG_ECHO, decoded[1], decoded[2],
											sensor_pos, OP_NOOP, decoded[5],
											0), neighbor[0])
									elif len(neighbor_list) == 1:
										if decoded[4] == OP_SIZE:
											peer.sendto(message_encode(
											MSG_ECHO_REPLY, decoded[1],
											decoded[2], sensor_pos, OP_SIZE,
											decoded[5], 1), address)
										elif decoded[4] == OP_SUM:
											peer.sendto(message_encode(
											MSG_ECHO_REPLY, decoded[1],
											decoded[2], sensor_pos, OP_SUM,
											decoded[5], sensor_val), address)
										elif decoded[4] == OP_MIN:
											peer.sendto(message_encode(
											MSG_ECHO_REPLY, decoded[1],
											decoded[2], sensor_pos, OP_MIN,
											decoded[5], sensor_val), address)
										elif decoded[4] == OP_MAX:
											peer.sendto(message_encode(
											MSG_ECHO_REPLY, decoded[1],
											decoded[2], sensor_pos, OP_MAX,
											decoded[5], sensor_val), address)
										elif decoded[4] == OP_SAME:
											print sensor_val
											print decoded[6]
											if sensor_val == int(decoded[6]):
												peer.sendto(message_encode(
												MSG_ECHO_REPLY, decoded[1],
												decoded[2], sensor_pos,
												OP_SAME, decoded[5], 1),
												address)
											else:
												peer.sendto(message_encode(
												MSG_ECHO_REPLY, decoded[1],
												decoded[2], sensor_pos,
												OP_SAME, decoded[5], 0),
												address)
										else:
											peer.sendto(message_encode(
											MSG_ECHO_REPLY, decoded[1],
											decoded[2], sensor_pos, OP_NOOP,
											decoded[5], 0), address)
											#window.writeln("Echo_send\n")
							else:
								if decoded[4] == OP_SIZE:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos,
									OP_SIZE, decoded[5], 0), address)
								elif decoded[4] == OP_SUM:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos, OP_SUM,
									decoded[5], 0), address)
								elif decoded[4] == OP_MIN:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos, OP_MIN,
									decoded[5], 0), address)
								elif decoded[4] == OP_MAX:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos, OP_MAX,
									decoded[5], 0), address)
								elif decoded[4] == OP_SAME:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos,
									OP_SAME, decoded[5], 0), address)
								else:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos,
									OP_NOOP, decoded[5], 0), address)
						elif decoded[0] == MSG_ECHO_REPLY:
							#window.writeln("Echo received back\n")
							echo_id = (decoded[1], decoded[2])
							echos[echo_id][0] = echos[echo_id][0] - 1

							if decoded[4] == OP_SIZE or decoded[4] == OP_SUM \
							   or decoded[4] == OP_SAME:
								echos[echo_id][2] += decoded[6]
							elif decoded[4] == OP_MIN:
								if decoded[6] != 0 and echos[echo_id][2] != 0:
									echos[echo_id][2] = min(echos[echo_id][2],
															decoded[6])
								elif decoded[6] != 0:
									echos[echo_id][2] = decoded[6]
							elif decoded[4] == OP_MAX:
								echos[echo_id][2] = max(echos[echo_id][2],
														decoded[6])


							if echos[echo_id][0] == 0:
								#window.writeln("Got echo back from all children\n")
								if decoded[2] == sensor_pos:
									if decoded[4] == OP_SIZE:
										window.writeln("Size of network is: "
										+ str(int(echos[echo_id][2] + 1)))
									elif decoded[4] == OP_SUM:
										window.writeln("The sum of the sensor "
										+ "values is: "
										+ str(int(echos[echo_id][2]
												  + sensor_val)))
									elif decoded[4] == OP_MIN:
										if echos[echo_id][2] != 0:
											echos[echo_id][2] = \
											min(echos[echo_id][2], sensor_val)
										else:
											echos[echo_id][2] = sensor_val
										window.writeln("The minimum sensor "
										+ "value is: "
										+ str(int(echos[echo_id][2])))
									elif decoded[4] == OP_MAX:
										window.writeln("The maximum sensor "
										+ "value is: "
										+ str(int(max(echos[echo_id][2],
													  sensor_val))))
									elif decoded[4] == OP_SAME:
										window.writeln("The amount of other "
										+ "sensors that have the same "
										+ "value is: "
										+ str(int(echos[echo_id][2])))
									else:
										window.writeln("Echo completed\n")
								elif decoded[4] == OP_SIZE:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos,
									OP_SIZE, sensor_val,
									(echos[echo_id][2] + 1)),
									echos[echo_id][1])
								elif decoded[4] == OP_SUM:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos, OP_SUM,
									sensor_val, (echos[echo_id][2]
									+ sensor_val)), echos[echo_id][1])
								elif decoded[4] == OP_MIN:
									if echos[echo_id][2] != 0:
										echos[echo_id][2] = min(
										echos[echo_id][2], sensor_val)
									else:
										echos[echo_id][2] = sensor_val
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos, OP_MIN,
									sensor_val, echos[echo_id][2]),
									echos[echo_id][1])
								elif decoded[4] == OP_MAX:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos, OP_MAX,
									sensor_val, (max(echos[echo_id][2],
									sensor_val))), echos[echo_id][1])
								elif decoded[4] == OP_SAME:
									if int(sensor_val) == \
									   int(echos[echo_id][3]):
										echos[echo_id][2] += 1
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos,
									OP_SAME, sensor_val, echos[echo_id][2]),
									echos[echo_id][1])
								else:
									peer.sendto(message_encode(MSG_ECHO_REPLY,
									decoded[1], decoded[2], sensor_pos,
									OP_NOOP, sensor_val, 0), echos[echo_id][1])
	thread.cancel()

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
