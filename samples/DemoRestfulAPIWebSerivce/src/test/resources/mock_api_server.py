#!/usr/bin/env python3
import json
from http.server import HTTPServer, BaseHTTPRequestHandler


class Handler(BaseHTTPRequestHandler):
    def do_GET(self):
        data = {
            "status": "success",
            "data": {
                "id": 2,
                "employee_name": "Garrett Winters",
                "employee_salary": 170750,
                "employee_age": 63
            },
            "message": "Successfully! Record has been fetched."
        }
        body = json.dumps(data).encode()
        self.send_response(200)
        self.send_header("Content-Type", "application/json")
        self.send_header("Content-Length", str(len(body)))
        self.end_headers()
        self.wfile.write(body)

    def log_message(self, format, *args):
        pass


if __name__ == "__main__":
    server = HTTPServer(("127.0.0.1", 29080), Handler)
    print("Mock API server running on http://127.0.0.1:29080", flush=True)
    server.serve_forever()
