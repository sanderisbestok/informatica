#!/usr/bin/python
import socket
import time

#create socket
s = socket.socket(
    socket.AF_INET, socket.SOCK_STREAM)
s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
s.bind(("localhost", 8081))
s.listen(1)

c, _ = s.accept()


c.send("Hey there!")
time.sleep(5)
c.recv(512)
