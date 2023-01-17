from mysql.connector import connect, Error
import time

try:
    with connect(
        host="127.0.0.1",
        user="root",
        password="password",
    ) as connection:
        use_db = "USE mydb"
        insert_query = "INSERT INTO number(number) VALUES (rand()*1024)"
        with connection.cursor() as cursor:
            cursor.execute(use_db)
            for i in range(1000):
                cursor.execute(insert_query)
                connection.commit()
                time.sleep(5)
except Error as e:
    print(e)