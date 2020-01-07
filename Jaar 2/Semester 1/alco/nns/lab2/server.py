"""
Lab 2 - HTTP Server
NAME: Sander Hansen
STUDENT ID: 10995080
DESCRIPTION: The main part of the server
"""
import socket
import mimetypes
import urllib
import subprocess


def serve(port, public_html, cgibin):
    """
    The entry point of the HTTP server.
    port: The port to listen on.
    public_html: The directory where all static files are stored.
    cgibin: The directory where all CGI scripts are stored.
    """

    # Create socket
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    s.bind(("localhost", port))
    s.listen(1)

    while 1:
        c, ip = s.accept()
        ip_adress = ip[0]

        # Save request
        method_string = c.recv(1024)
        method = method_string.split(" ", 1)[0]

        if method == "GET":
            argument = method_string.split(" ", 2)[1]

            # Check if path was given to the server
            if argument == "/":
                argument = "/index.html"

            # Check for CGI
            if argument.startswith("/cgi-bin/"):
                cgi_path = argument.split("/", 2)[2]

                if "?" in argument:
                    cgi_variable = argument.split("?", 1)[1]
                    cgi_path = "/" + cgi_path.split("?", 1)[0]
                else:
                    cgi_variable = ""
                    cgi_path = "/" + cgi_path

                if (os.path.isfile(cgibin + cgi_path)):
                    header = "HTTP/1.1 200 OK\r\n"
                    c.send(header)
                    content = open_cgi(cgi_path, cgi_variable, ip_adress)
                    c.send(content)
                else:
                    content = error_404()
                    header = make_header(content, 404, "404.html")
                    c.send(header + content)

            # Check if file exist
            elif (os.path.isfile(public_html + argument)):
                with open(public_html + argument, "r") as webpage:
                    content = webpage.read()
                    header = make_header(content, 200, argument)
                c.send(header + content)
            else:
                content = error_404()
                header = make_header(content, 404, "404.html")
                c.send(header + content)
        # If not GET the request is not implemented, error was send
        else:
            content = """
                <html>
                    <head>
                        <title>501</title>
                    </head>
                    <body>
                        <h1>501: Not implemented</h1>
                    </body>
                </html>
            """

            header = make_header(content, 501, "501.html")
            c.send(header + content)

        c.close()


def make_header(content, code, path):
    content_length = len(content)
    url = urllib.pathname2url(path)

    if code == 200:
        header = "HTTP/1.1 200 OK\r\n"
    elif code == 404:
        header = "HTTP/1.1 404 Not Found\r\n"
    elif code == 501:
        header = "HTTP/1.1 501 Not Implemented\r\n"

    header += "Connection: close\r\n"
    header += "Content-Type: " + mimetypes.guess_type(url)[0] + "\r\n"
    header += "Content-Length: " + str(content_length) + "\r\n"
    header += "Server: Sherrif's Crib\r\n\r\n"

    return header


def error_404():
    content = """
        <html>
            <head>
                <title>404</title>
            </head>
            <body>
                <h1>404: Page does not exist</h1>
            </body>
        </html>
    """
    return content


def open_cgi(cgi_path, cgi_variable, ip_adress):
    cgi = subprocess.Popen(
        ["python", cgibin + cgi_path, public_html, "GET",
            cgi_path, cgi_variable, os.path.dirname(os.path.abspath(__file__)),
            ip_adress], stdout=subprocess.PIPE)
    content = cgi.communicate()[0]

    return content


# This the entry point of the script.
# Do not change this part.
if __name__ == '__main__':
    import os
    import sys
    import argparse
    p = argparse.ArgumentParser()
    p.add_argument('--port', help='port to bind to', default=8080, type=int)
    p.add_argument('--public_html', help='home directory',
                   default='./public_html')
    p.add_argument('--cgibin', help='cgi-bin directory', default='./cgi-bin')
    args = p.parse_args(sys.argv[1:])
    public_html = os.path.abspath(args.public_html)
    cgibin = os.path.abspath(args.cgibin)
    serve(args.port, public_html, cgibin)
