from flask import Flask, jsonify, request
from flask_cors import CORS  # Importáld be a CORS modult
import mysql.connector
from datetime import datetime

app = Flask(__name__)
CORS(app)  # Engedélyezd a CORS-t az alkalmazásodban

# Adatbázis kapcsolat beállítása
db = mysql.connector.connect(
    host="localhost",
    user="merfed",
    password="merfed",
    database="todo"
)

@app.route('/api/adatok', methods=['GET'])
def get_adatok():
    # Ellenőrzi, hogy a 'table' query paraméter meg van-e adva
    table_name = request.args.get("table")
    
    # Ellenőrzi, hogy a megadott tábla létezik
    cursor = db.cursor()
    cursor.execute(f"SHOW TABLES LIKE '{table_name}'")
    table_exists = cursor.fetchone() is not None
    cursor.close()
    
    if not table_name or not table_exists:
        return jsonify({"message": "Nincs megadva vagy nem létezik az adattábla"}), 400
    
    cursor = db.cursor(dictionary=True)
    cursor.execute(f"SELECT * FROM {table_name} ORDER BY status, serialNum")
    results = cursor.fetchall()
    cursor.close()
    
    return jsonify(results)

@app.route('/api/tables', methods=['GET'])
def get_tables():
    db_name = request.args.get("database")
    
    # Ellenőrizze, hogy az adatbázis létezik-e
    cursor = db.cursor()
    cursor.execute("SHOW DATABASES")
    databases = [db[0] for db in cursor.fetchall()]
    cursor.close()
    
    if db_name not in databases:
        return jsonify({"message": "Az adatbázis nem létezik"}), 404
    
    # Lekérdezi az adattáblák nevét az adott adatbázisban
    cursor = db.cursor()
    cursor.execute(f"USE {db_name}")
    cursor.execute("SHOW TABLES")
    tables = [table[0] for table in cursor.fetchall()]
    cursor.close()
    
    return jsonify({"tables": tables})

@app.route('/api/dbs', methods=['GET'])
def get_dbs():
    # Lekérdezi az összes adatbázis nevét
    cursor = db.cursor()
    cursor.execute("SHOW DATABASES")
    databases = [db[0] for db in cursor.fetchall()]
    cursor.close()
    return jsonify({"databases": databases})

@app.route('/api/lekerdezes', methods=['POST'])
def lekerdezes():
    data = request.json
    db_name = data.get("database")
    filter_column = data.get("filter_column")
    filter_value = data.get("filter_value")
    
    # Ellenőrizze, hogy a megadott adatbázis létezik
    cursor = db.cursor()
    cursor.execute("SHOW DATABASES")
    databases = [db[0] for db in cursor.fetchall()]
    cursor.close()
    
    if db_name not in databases:
        return jsonify({"message": "Az adatbázis nem létezik"}), 404
    
    cursor = db.cursor(dictionary=True)
    query = f"SELECT * FROM {db_name} WHERE {filter_column} = %s"
    cursor.execute(query, (filter_value,))
    results = cursor.fetchall()
    cursor.close()
    return jsonify(results)

@app.route('/api/uj_adatbazis', methods=['POST'])
def uj_adatbazis():
    data = request.json
    db_name = data.get("database")
    
    # Ellenőrizze, hogy az adatbázis létezik-e
    cursor = db.cursor()
    cursor.execute("SHOW DATABASES")
    databases = [db[0] for db in cursor.fetchall()]
    cursor.close()
    
    if db_name in databases:
        return jsonify({"message": "Az adatbázis már létezik"}), 400
    
    # Hozzon létre egy új adatbázist
    cursor = db.cursor()
    cursor.execute(f"CREATE DATABASE {db_name}")
    cursor.close()
    
    return jsonify({"message": f"Az adatbázis '{db_name}' létre lett hozva"}), 201

@app.route('/api/get_data_where', methods=['POST'])
def get_data_where():
    data = request.json
    db_name = data.get("database")
    filter_column = data.get("filter_column")
    filter_value = data.get("filter_value")
    
    # Ellenőrizze, hogy a megadott adatbázis létezik
    cursor = db.cursor()
    cursor.execute("SHOW DATABASES")
    databases = [db[0] for db in cursor.fetchall()]
    cursor.close()
    
    if db_name not in databases:
        return jsonify({"message": "Az adatbázis nem létezik"}), 404
    
    cursor = db.cursor(dictionary=True)
    query = f"SELECT * FROM {db_name} WHERE {filter_column} = %s"
    cursor.execute(query, (filter_value,))
    results = cursor.fetchall()
    cursor.close()
    
    return jsonify(results)

@app.route('/api/set_data', methods=['POST'])
def set_data():
    data = request.json
    db_name = data.get("database")
    table_name = data.get("table_name")
    id_value = data.get("id")
    account_value = data.get("account")
    status_value = data.get("status")
    serialNum_value = data.get("serialNum")
    mode_value = datetime.now()
    #comment_value = data.get("comment") ideiglenesen kiszedtük de vissza kell majd tenni
    
    # Ellenőrizze, hogy a megadott adatbázis létezik
    cursor = db.cursor()
    cursor.execute("SHOW DATABASES")
    databases = [db[0] for db in cursor.fetchall()]
    cursor.close()
    
    if db_name not in databases:
        return jsonify({"message": "Az adatbázis nem létezik"}), 404
    
    cursor = db.cursor(dictionary=True)
    query = f"UPDATE {db_name}.{table_name} SET `mode` = %s, `account` = %s, `status` = %s, `serialNum` = %s WHERE `id` = %s"
    cursor.execute(query, (mode_value, account_value, status_value, serialNum_value, id_value))
    db.commit()
    cursor.close()
    
    return jsonify({"message": "Az adatok frissítve lettek"})

@app.route('/api/sort_data', methods=['POST'])
def sort_data():
    data = request.json
    db_name = data.get("database")
    table_name = data.get("table_name")
    sorted_ids = data.get("sorted_ids")

    # Ellenőrizze, hogy a megadott adatbázis létezik
    cursor = db.cursor()
    cursor.execute("SHOW DATABASES")
    databases = [db[0] for db in cursor.fetchall()]
    cursor.close()

    if db_name not in databases:
        return jsonify({"message": "Az adatbázis nem létezik"}), 404

    # Frissíti a sorrendet az adatbázisban
    cursor = db.cursor(dictionary=True)
    try:
        for index, item_id in enumerate(sorted_ids, start=1):
            query = f"UPDATE {db_name}.{table_name} SET `serialNum` = %s WHERE `id` = %s"
            cursor.execute(query, (index, item_id))
        db.commit()
        cursor.close()
        return jsonify({"message": "Az adatok sorrendje frissítve lett"})
    except Exception as e:
        db.rollback()
        cursor.close()
        return jsonify({"message": f"Hiba történt: {str(e)}"}), 500


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
