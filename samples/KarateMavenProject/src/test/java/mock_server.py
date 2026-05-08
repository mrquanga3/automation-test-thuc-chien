#!/usr/bin/env python3
"""Simple mock server for Karate UI tests."""
from http.server import HTTPServer, BaseHTTPRequestHandler
import urllib.parse

LOGIN_PAGE = """<!DOCTYPE html>
<html>
<head><title>Administration</title></head>
<body>
<form id="form-login" method="post" action="/admin/login">
  <input type="text" id="input-username" name="username" placeholder="Username" />
  <input type="password" id="input-password" name="password" placeholder="Password" />
  <button type="submit"><i class="fa fa-lock"></i></button>
</form>
</body>
</html>"""

ERROR_PAGE = """<!DOCTYPE html>
<html>
<head><title>Administration</title></head>
<body>
<div class="alert alert-danger alert-dismissible"> No match for Username and/or Password. </div>
<form id="form-login" method="post" action="/admin/login">
  <input type="text" id="input-username" name="username" placeholder="Username" />
  <input type="password" id="input-password" name="password" placeholder="Password" />
  <button type="submit"><i class="fa fa-lock"></i></button>
</form>
</body>
</html>"""


class Handler(BaseHTTPRequestHandler):
    def do_GET(self):
        self.send_response(200)
        self.send_header("Content-Type", "text/html")
        self.end_headers()
        self.wfile.write(LOGIN_PAGE.encode())

    def do_POST(self):
        length = int(self.headers.get("Content-Length", 0))
        body = self.rfile.read(length).decode()
        params = urllib.parse.parse_qs(body)
        username = params.get("username", [""])[0]
        password = params.get("password", [""])[0]
        self.send_response(200)
        self.send_header("Content-Type", "text/html")
        self.end_headers()
        if username == "admin" and password == "admin":
            self.wfile.write(b"<html><body>Welcome Admin</body></html>")
        else:
            self.wfile.write(ERROR_PAGE.encode())

    def log_message(self, format, *args):
        pass


if __name__ == "__main__":
    server = HTTPServer(("127.0.0.1", 18080), Handler)
    print("Mock server running on http://127.0.0.1:18080", flush=True)
    server.serve_forever()
