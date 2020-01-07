"""
Lab 3 - Chat Room (Client)
NAME: Sander Hansen
STUDENT ID: 10995080
DESCRIPTION: Client for the chat server. SSL certificate required. Once the
server is running you can start this client.
"""

from gui import MainWindow
import socket
import select
import time
import os
import ssl


def loop(port, cert):
    """
    GUI loop.
    port: port to connect to.
    cert: public certificate (bonus task)
    """

    path = os.path.dirname(os.path.abspath(__file__))
    ssl_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    # SSL idea from http://bit.ly/2cJJCRn
    s = ssl.wrap_socket(ssl_socket, ca_certs=path + "/keys/server.crt",
                        cert_reqs=ssl.CERT_REQUIRED)
    s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    s.connect(("localhost", port))

    # The following code explains how to use the GUI.
    w = MainWindow()
    connected = True
    exit = True

    # update() returns false when the user quits or presses escape.
    while w.update():
        if connected is True:
            read_ready, write_ready, error = select.select([s], [], [], 0)

            # Feedback van server
            for sock in read_ready:
                server_data = sock.recv(1024)
                w.writeln(server_data)

                if not server_data:
                    w.writeln("You are disconnected from the server")
                    w.writeln("Please exit and try again")
                    connected = False
            # if the user entered a line getline() returns a string.
            line = w.getline()
            if line:
                w.writeln("You: " + line)
                s.send(line)
        else:
            s.close()


# Command line parser.
if __name__ == '__main__':
    import sys
    import argparse
    p = argparse.ArgumentParser()
    p.add_argument('--port', help='port to connect to',
                   default=12345, type=int)
    p.add_argument('--cert', help='server public cert', default='')
    args = p.parse_args(sys.argv[1:])
    loop(args.port, args.cert)
