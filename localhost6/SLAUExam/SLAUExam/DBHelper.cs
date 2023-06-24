using MySqlConnector;

public class DBHelper
{
    private static MySqlConnection? conn = null;
    private DBHelper(string host, int port, string user, string password, string database)
    {
        var connStr = $"Server={host};port={port};database={database};User Id={user};password={password}";
        conn = new MySqlConnection(connStr);
        conn?.Open();
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


    private int GetVarsAmount(int id)
    {
        int varsAmount = 0;

        string query = $"SELECT varsAmount FROM `system` WHERE id = {id}";
        using (var command = new MySqlCommand(query, conn))
        {
            using (var reader = command.ExecuteReader())
            {
                if (reader.Read())
                {
                    varsAmount = reader.GetInt32("varsAmount");
                }
            }
        }

        return varsAmount;
    }

    private double GetCoefficient(int systemId, int rowId, int colId)
    {
        double coefficient = 0;

        string query = $"SELECT value FROM coefficients WHERE system_id = {systemId} AND row_id = {rowId} AND col_id = {colId}";
        using (var command = new MySqlCommand(query, conn))
        {
            using (var reader = command.ExecuteReader())
            {
                if (reader.Read())
                {
                    coefficient = reader.GetDouble("value");
                }
            }
        }

        return coefficient;
    }

    public double[,] getMatrix(int id)
    {
        int n = GetVarsAmount(id);
        var matrix = new double[n, n];

        for (int i = 1; i <= n; i++)
        {
            for (int j = 1; j <= n; j++)
            {
                matrix[i - 1, j - 1] = GetCoefficient(id, i, j);
            }
        }

        return matrix;
    }

    public double[] getConstants(int id)
    {
        int n = GetVarsAmount(id);
        var constants = new double[n];

        for (int i = 1; i <= n; i++)
        {
            constants[i - 1] = GetCoefficient(id, i, 0);
        }

        return constants;
    }



    public List<int> GetIdWithNullAnswer(string login)
    {
        List<int> ids = new List<int>();

        var queryStr = "SELECT `system`.id FROM `system` INNER JOIN `Users` ON `system`.user_login = `Users`.login WHERE `Users`.login = @login AND `system`.answer IS NULL";
        var cmd = conn?.CreateCommand();
        cmd.CommandText = queryStr;
        cmd.Parameters.AddWithValue("@login", login);

        using (var reader = cmd.ExecuteReader())
        {
            if (reader.HasRows)
            {
                while (reader.Read())
                {
                    int id = reader.GetInt32(reader.GetOrdinal("id"));
                    ids.Add(id);
                }
            }
        }
        return ids;
    }

    public bool UpdateAnswer(string answer, int systemId)
    {
        try
        {
            using (var cmd = conn.CreateCommand())
            {
                cmd.CommandText = "UPDATE `system` SET Answer = @Answer WHERE id = @SystemId";
                cmd.Parameters.AddWithValue("@Answer", answer);
                cmd.Parameters.AddWithValue("@SystemId", systemId);
                cmd.ExecuteNonQuery();
            }
            return true;
        }
        catch (Exception e)
        {
            Console.WriteLine(e.ToString());
            return false;
        }
    }

}