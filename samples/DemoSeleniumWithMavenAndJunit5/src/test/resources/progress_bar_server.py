#!/usr/bin/env python3
from http.server import HTTPServer, BaseHTTPRequestHandler

HTML = b"""<!DOCTYPE html>
<html>
<head><title>Progress Bar Demo</title></head>
<body>
<div id="progressBar" role="progressbar"
     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
     style="width:0%;height:30px;background:#007bff;transition:width 0.1s;"></div>
<br/>
<button id="startStopButton" onclick="startProgress()">Start</button>
<script>
function startProgress() {
  var bar = document.getElementById('progressBar');
  var val = 0;
  var interval = setInterval(function() {
    val += 5;
    bar.setAttribute('aria-valuenow', val);
    bar.style.width = val + '%';
    if (val >= 100) clearInterval(interval);
  }, 50);
}
</script>
</body>
</html>"""


class Handler(BaseHTTPRequestHandler):
    def do_GET(self):
        self.send_response(200)
        self.send_header("Content-Type", "text/html")
        self.send_header("Content-Length", str(len(HTML)))
        self.end_headers()
        self.wfile.write(HTML)

    def log_message(self, format, *args):
        pass


if __name__ == "__main__":
    server = HTTPServer(("127.0.0.1", 29081), Handler)
    print("Progress bar server running on http://127.0.0.1:29081", flush=True)
    server.serve_forever()
