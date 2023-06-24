using MySqlConnector;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace IntegralCounterExam
{
    internal class DBHelper
    {

        private const string dbName = "IntegralExam";

        private static MySqlConnection? conn = null;
        private DBHelper(string host, int port, string user, string password, string database)
        {
            var connStr = $"Server={host};port={port};UserId={user};password={password}";
            conn = new MySqlConnection(connStr);
            conn?.Open();

            // Создаем базу данных, если она не существует
            CreateDatabaseAndTableIfNotExists();
            // Используем выбранную базу данных
            conn.ChangeDatabase(database);
        }

        private static DBHelper instance = null;
        public static DBHelper GetInstance(string host = "localhost", int port = 0, string user = "root", string password = "", string database = "")
        {
            if (instance == null)
            {
                instance = new DBHelper(host, port, user, password, database);
            }
            return instance;
        }

        public void CreateDatabaseAndTableIfNotExists()
        {
            var createDatabaseQuery = $"CREATE DATABASE IF NOT EXISTS {dbName};";
            var createTableQuery = $@"
                USE {dbName};
                CREATE TABLE IF NOT EXISTS Integral (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    lowerLimit DOUBLE,
                    upperLimit DOUBLE,
                    intervals INT,
                    answer DOUBLE,
                    func VARCHAR(255),
                    
                );
                CREATE TABLE IF NOT EXISTS Users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    login VARCHAR(255),
                    password VARCHAR(255)
                );
            ";

            var cmd = new MySqlCommand(createDatabaseQuery, conn);
            cmd.ExecuteNonQuery();

            cmd = new MySqlCommand(createTableQuery, conn);
            cmd.ExecuteNonQuery();
        }

        public void InsertData(double lowerLimit, double upperLimit, int interval, double answer, string function)
        {
            var insertQuery = $@"
            USE {dbName};
            INSERT INTO Integral (lowerLimit, upperLimit, intervals, answer, func)
            VALUES (@lowerLimit, @upperLimit, @interval, @answer, @function);";

            var cmd = new MySqlCommand(insertQuery, conn);
            cmd.Parameters.AddWithValue("@lowerLimit", lowerLimit);
            cmd.Parameters.AddWithValue("@upperLimit", upperLimit);
            cmd.Parameters.AddWithValue("@interval", interval);
            cmd.Parameters.AddWithValue("@answer", answer);
            cmd.Parameters.AddWithValue("@function", function);

            cmd.ExecuteNonQuery();
        }
    }
}
