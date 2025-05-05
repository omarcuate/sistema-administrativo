import tkinter as tk
from tkinter import filedialog
import openpyxl

def seleccionar_archivo():
    root = tk.Tk()
    root.withdraw() # Oculta la ventana principal

    archivo_excel = filedialog.askopenfilename(filetypes=[("Archivo Excel", "*.xlsx;*.xls")])

    if archivo_excel:
        return archivo_excel
    else:
        print("No se ha seleccionado ningún archivo.")
        return None

def main():
    archivo_excel = seleccionar_archivo()

    if archivo_excel:
        wb = openpyxl.load_workbook(archivo_excel)
        hoja = wb.active
        hoja.insert_rows(1)
        
        datos_nueva_fila = ["CLAVE CATASTRAL", "CLAVE MUNICIPIO", "DOMICILIO", "NOMPROP", "RFC", "ESTATUS CLAVE", "VALOR CATASTRAL", "SUPTERR", "SUPCONS", "USOAREAHOMO", "REC_IMP_CORRIENTE", "REC_IMP_REZADO", "REC_ACC_CORRIENTE", "REC_ACC_REZAGO", "REC_DESC_CORRIENTE", "REC_DESC_REZAGO", "PER_CORR_PERIODO", "PER_CORR_EJEFISCAL", "PER_REZ_PERIODO", "PER_REZ_EJEFISCAL", "F_PAGODIA", "F_PAGOMES", "ADEUDO_PEJEFISCAL", "ADEUDO_PPERIODO", "ADEUDO_PIMPORTE", "ADEUDO_ACCPERIODO", "ADEUDO_ACCIMPORTE", "F_VERSION"]

        for i, dato in enumerate(datos_nueva_fila, start=1):
            hoja.cell(row=1, column=i).value = dato
        
        wb.save(archivo_excel)
        print("Se ha creado una nueva fila con los datos especificados en el archivo:", archivo_excel)

if __name__ == "__main__":
    main()
