"""
Lab 3 - Chat Room (Server)
NAME: Sander Hansen
STUDENT ID: 10995080
DESCRIPTION: This is the server for the chat application. A SSL certificate is
required.
"""

import socket
import select
import ssl
import os
import sys

nick_names = {}
ips = {}
filters = {}
connections = []


def serve(port):
    """
    Chat server entry point.
    port: The port to listen on.
    """

    # Create socket
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    s.bind(("localhost", port))
    s.listen(1)

    connections.append(s)

    while 1:
        read_ready, write_ready, error = select.select(connections, [], [], 0)

        for sock in read_ready:

            if sock == s:
                # Connection is socket, ip is user ip
                ssl_connection, ip = sock.accept()
                path = os.path.dirname(os.path.abspath(__file__))
                # SSL idea from http://bit.ly/2cJJCRn
                connection = ssl.wrap_socket(ssl_connection, server_side=True,
                                             certfile=path + "/keys/server.crt",
                                             keyfile=path + "/keys/server.key")
                connections.append(connection)
                new_user(connection, ip, s)
            else:
                data = sock.recv(1024)

                if data:
                    try:
                        command = data.split(" ", 1)[0]
                        variable = data.split(" ", 1)[1]
                    except:
                        command = data
                        variable = ""

                    if command == "/nick":
                        if variable != "":
                            command_nick(variable, s, sock)
                        else:
                            sock.send("An argument is needed for this command")
                    elif command == "/say":
                        if variable != "":
                            command_say(variable, s, sock)
                        else:
                            sock.send("An argument is needed for this command")
                    elif command == "/whisper":
                        if variable != "":
                            command_whisper(variable, sock)
                        else:
                            sock.send("An argument is needed for this command")
                    elif command == "/list":
                        command_list(sock)
                    elif command == "/help" or command == "/?":
                        command_help(sock)
                    elif command == "/me":
                        if variable != "":
                            command_me(variable, s, sock)
                        else:
                            sock.send("An argument is needed for this command")
                    elif command == "/whois":
                        if variable != "":
                            command_whois(variable, sock)
                        else:
                            sock.send("An argument is needed for this command")
                    elif command == "/filter":
                        if variable != "":
                            command_filter(variable, sock)
                        else:
                            sock.send("An argument is needed for this command")
                    elif command.startswith("/"):
                        sock.send("This is not a valid command")
                    else:
                        command_say(data, s, sock)
                else:
                    exit_user(sock, s)
                    sock.close()


def exit_user(current_sock, s):
    nick_name = nick_names[current_sock]

    message = nick_name + " disconnected from the server"
    send_message(message, s, current_sock)

    del nick_names[current_sock]
    del ips[current_sock]

    if current_sock in filters:
        del filters[current_sock]

    connections.remove(current_sock)
    current_sock.close()


def new_user(current_sock, ip, s):
    nick_names[current_sock] = str(ip)
    ips[current_sock] = str(ip)

    message = "Welcome to this chat room, use /help for a list of commands"
    current_sock.send(message)

    message = nick_names[current_sock] + " joined the chat room"
    send_message(message, s, current_sock)


def send_message(message, s, current_sock):
    original_message = message

    for sock in connections:
        if not sock == s and not sock == current_sock:
            message = check_filter(message, sock)

            sock.send(message)
            message = original_message


def check_filter(message, sock):
    if sock in filters:
        current_filter = filters[sock]
        for filter_word in current_filter:
            if filter_word in message:
                return "This message has been filtered"

    return message


def command_nick(new_name, s, current_sock):
    if new_name in nick_names.values():
        current_sock.send("This nickname is already taken")
    else:
        old_name = nick_names[current_sock]
        nick_names[current_sock] = new_name
        current_sock.send("Your nickname has been changed to: " + new_name)
        message = old_name + " is now called: " + new_name
        send_message(message, s, current_sock)


def command_say(message, s, current_sock):
    nick_name = nick_names[current_sock]
    message = nick_name + ": " + message

    send_message(message, s, current_sock)


def command_whisper(variable, current_sock):
    try:
        user = variable.split(" ", 1)[0]
        message = variable.split(" ", 1)[1]
    except:
        current_sock.send("No message included")
        return

    # Getting value by key code from http://bit.ly/2clRPIB
    sock = [k for k, v in nick_names.iteritems() if v == user]

    if not sock:
        current_sock.send("Nickname not found")
        return

    message = check_filter(message, sock[0])
    sock[0].send(nick_names[current_sock] + " [private]: " + message)


def command_list(current_sock):
    current_sock.send("\nThe following users are currently online\n")
    for name in nick_names.values():
        current_sock.send(name + "\n")


def command_help(current_sock):
    message = """
        You can use the following command in this chat room:

        /nick <user>
            Sets your nickname, unless it is already taken.
        /say <text> or <text>
            Every user receives the chat message.
        /whisper <user> <text>
            Only the specified user receives the chat message.
        /list
            Get a list of all the connected users.
        /help or /?
            Get this page
        /me <text>
            Prints an action in the following format: <my username> <message>
        /whois <user>
            Prints information about the user
        /filter <word>
            Filter every message containing <word>
    """

    current_sock.send(message)


def command_me(message, s, current_sock):
    nick_name = nick_names[current_sock]
    me_message = nick_name + " " + message

    send_message(me_message, s, s)


def command_whois(user, current_sock):
    # Getting value by key code from http://bit.ly/2clRPIB
    dest_sock = [k for k, v in nick_names.iteritems() if v == user]

    if not dest_sock:
        current_sock.send("Nickname not found")
        return

    ip = ips[dest_sock[0]]

    current_sock.send(user + " is connected from the following address: \n" +
                        ip)


def command_filter(variable, current_sock):
    if current_sock not in filters:
        filters[current_sock] = []

    filter_list = filters[current_sock]
    filter_list.append(variable)
    filters[current_sock] = filter_list

    current_sock.send(variable + " is added to the filter list")

# Command line parser.
if __name__ == '__main__':
    import sys
    import argparse
    p = argparse.ArgumentParser()
    p.add_argument('--port', help='port to listen on', default=12345, type=int)
    args = p.parse_args(sys.argv[1:])
    serve(args.port)
