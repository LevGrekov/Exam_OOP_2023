using MySqlConnector;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace IntegralForExamWithGUI
{
    internal class DBHelper
    {

        private const string dbName = "MyDataBaseForExam";

        private static MySqlConnection? conn = null;
        private DBHelper(string host, int port, string user, string password)
        {
            var connStr = $"Server={host};port={port}; database={dbName};UserId={user};password={password}";
            conn = new MySqlConnection(connStr);
            conn?.Open();
        }

        private static DBHelper? instance = null;
        public static DBHelper GetInstance(string host = "localhost", int port = 0, string user = "root", string password = "", string database = "")
        {
            if (instance == null)
            {
                instance = new DBHelper(host, port, user, password);
            }
            return instance;
        }

        public void InsertData(byte[] data)
        {
            string insertQuery = @"
        INSERT INTO integralgraph (data)
        VALUES (@data);";

            using (MySqlCommand cmd = new MySqlCommand(insertQuery, conn))
            {
                cmd.Parameters.AddWithValue("@data", data);

                cmd.ExecuteNonQuery();
            }
        }
    }
}