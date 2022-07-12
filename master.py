from mysql.connector import connect, Error

try:
    with connect(
        host="127.0.0.1",
        user="root",
        password="password",
    ) as connection:
        create_db = "CREATE DATABASE mydb"
        use_db = "USE mydb"
        create_slave_user = "CREATE USER 'slave'@'%' IDENTIFIED BY 'password'"
        grant_permissions = "GRANT REPLICATION SLAVE ON *.* TO 'slave'@'%'"
        flush_privileges = "FLUSH PRIVILEGES"
        create_table_query = """
        CREATE TABLE number(
            id INT AUTO_INCREMENT PRIMARY KEY,
            number INT
        )
        """
        with connection.cursor() as cursor:
            cursor.execute(create_db)
            cursor.execute(use_db)
            cursor.execute(create_slave_user)
            cursor.execute(grant_permissions)
            cursor.execute(flush_privileges)
            cursor.execute(create_table_query)
except Error as e:
    print(e)