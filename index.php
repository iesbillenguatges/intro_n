import json
import time
from http.server import BaseHTTPRequestHandler, HTTPServer
from urllib.parse import parse_qs, urlparse

DATA_FILE = 'alumnes.json'

# Inicialitza el fitxer JSON si no existeix
try:
    with open(DATA_FILE, 'r', encoding='utf-8') as f: 
        json.load(f)
except (FileNotFoundError, json.JSONDecodeError):
    with open(DATA_FILE, 'w', encoding='utf-8') as f: 
        json.dump([], f)

class RequestHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        parsed_path = urlparse(self.path)
        
        # GESTIÓ D'ELIMINACIÓ: Si la ruta és /eliminar?id=XXX
        if parsed_path.path == '/eliminar':
            params = parse_qs(parsed_path.query)
            id_a_eliminar = params.get('id', [''])[0]
            
            if id_a_eliminar:
                with open(DATA_FILE, 'r+', encoding='utf-8') as f:
                    alumnes = json.load(f)
                    # Filtrem la llista per a excloure l'alumne amb aquest ID
                    alumnes = [a for a in alumnes if str(a.get('id')) != id_a_eliminar]
                    f.seek(0)
                    json.dump(alumnes, f, indent=4, ensure_ascii=False)
                    f.truncate()
            
            # Redirigim a la pàgina principal després d'eliminar
            self.send_response(303)
            self.send_header('Location', '/')
            self.end_headers()
            return

        # RUTA PRINCIPAL: Mostra el formulari i la llista
        with open(DATA_FILE, 'r', encoding='utf-8') as f:
            alumnes = json.load(f)
        
        # Generem les files de la taula amb el botó d'eliminar
        files_taula = ""
        for a in alumnes:
            a_id = a.get('id', '')
            files_taula += f"""<tr>
                <td>{a.get('nom', '')}</td>
                <td>{a.get('email', '')}</td>
                <td>
                    <a href="/eliminar?id={a_id}" class="btn-delete">Eliminar</a>
                </td>
            </tr>"""

        html = f"""<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Introducció al núvol</title>
            <style>
                body {{ font-family: Arial, sans-serif; max-width: 700px; margin: 40px auto; padding: 20px; }}
                form {{ background: #f4f4f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; }}
                input {{ width: 95%; padding: 8px; margin: 8px 0; }}
                button {{ background: #007bff; color: white; padding: 10px; border: none; width: 100%; border-radius: 4px; cursor: pointer; }}
                table {{ width: 100%; border-collapse: collapse; margin-top: 10px; }}
                th, td {{ border: 1px solid #ddd; padding: 10px; text-align: left; }}
                th {{ background: #f2f2f2; }}
                .btn-delete {{ color: #dc3545; text-decoration: none; font-weight: bold; }}
                .btn-delete:hover {{ text-decoration: underline; }}
            </style>
        </head>
        <body>
            <h1>Seminari: Introducció al núvol</h1>
            
            <form method="POST" action="/">
                <h3>Registrar nou alumne</h3>
                <label>Nom:</label>
                <input type="text" name="nom" required>
                <label>Email:</label>
                <input type="email" name="email" required>
                <button type="submit">Enviar</button>
            </form>

            <h2>Alumnes Inscrits</h2>
            <table>
                <tr><th>Nom</th><th>Email</th><th>Accions</th></tr>
                {files_taula}
            </table>
        </body>
        </html>
        """
        
        self.send_response(200)
        self.send_header('Content-type', 'text/html; charset=utf-8')
        self.end_headers()
        self.wfile.write(html.encode('utf-8'))

    def do_POST(self):
        # Llegim les dades del formulari enviat
        content_length = int(self.headers['Content-Length'])
        post_data = self.rfile.read(content_length).decode('utf-8')
        
        dades_formulari = parse_qs(post_data)
        
        # Generem un ID únic basat en el temps (timestamp en milisegons)
        id_unic = int(time.time() * 1000)
        
        nou_alumne = {
            "id": id_unic,
            "nom": dades_formulari.get('nom', [''])[0],
            "email": dades_formulari.get('email', [''])[0]
        }

        # Guardem al fitxer JSON
        with open(DATA_FILE, 'r+', encoding='utf-8') as f:
            alumnes = json.load(f)
            alumnes.append(nou_alumne)
            f.seek(0)
            json.dump(alumnes, f, indent=4, ensure_ascii=False)
            f.truncate()

        # Redirigim de nou a la pàgina principal
        self.send_response(303)
        self.send_header('Location', '/')
        self.end_headers()

def run():
    server_address = ('', 8080)
    httpd = HTTPServer(server_address, RequestHandler)
    print("Servidor funcionant al port 8080...")
    httpd.serve_forever()

if __name__ == '__main__':
    run()
