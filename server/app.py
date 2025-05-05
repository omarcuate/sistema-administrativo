from flask import Flask, render_template
import subprocess

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/ejecutar_script/<nombre>')
def ejecutar_script(nombre):
    ruta_script = f'scripts/tu/{nombre}.py'
    comando = f'python {ruta_script}'
    resultado = subprocess.run(comando, shell=True, capture_output=True, text=True)
    return f'Resultado de la ejecución del Script {nombre}:\n\n{resultado.stdout}\n\nErrores (si los hay):\n{resultado.stderr}'

@app.route('/sqls')
def sqls():
    return render_template('sqls.html')

@app.route('/limpieza')
def limpieza():
    return render_template('limpieza.html')

if __name__ == '__main__':
    app.run(debug=True)


