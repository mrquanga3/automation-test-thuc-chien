#!/usr/bin/env python3
from http.server import HTTPServer, BaseHTTPRequestHandler
import urllib.parse

LOGIN_PAGE = """<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<form method="post" action="/admin/">
  <input type="text" id="username" name="username" placeholder="Username" />
  <input type="password" id="password" name="password" placeholder="Password" />
  <input type="submit" id="submit" value="Submit" />
</form>
</body>
</html>"""

ERROR_PAGE = """<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<span id="error">Your username is invalid!</span>
<form method="post" action="/admin/">
  <input type="text" id="username" name="username" placeholder="Username" />
  <input type="password" id="password" name="password" placeholder="Password" />
  <input type="submit" id="submit" value="Submit" />
</form>
</body>
</html>"""


class Handler(BaseHTTPRequestHandler):
    def do_GET(self):
        body = LOGIN_PAGE.encode()
        self.send_response(200)
        self.send_header("Content-Type", "text/html")
        self.send_header("Content-Length", str(len(body)))
        self.end_headers()
        self.wfile.write(body)

    def do_POST(self):
        length = int(self.headers.get("Content-Length", 0))
        body_bytes = self.rfile.read(length).decode()
        params = urllib.parse.parse_qs(body_bytes)
        username = params.get("username", [""])[0]
        password = params.get("password", [""])[0]
        if username == "admin" and password == "admin":
            response = b"<html><body>Welcome Admin</body></html>"
        else:
            response = ERROR_PAGE.encode()
        self.send_response(200)
        self.send_header("Content-Type", "text/html")
        self.send_header("Content-Length", str(len(response)))
        self.end_headers()
        self.wfile.write(response)

    def log_message(self, format, *args):
        pass


if __name__ == "__main__":
    server = HTTPServer(("127.0.0.1", 18081), Handler)
    print("Mock server running on http://127.0.0.1:18081", flush=True)
    server.serve_forever()
