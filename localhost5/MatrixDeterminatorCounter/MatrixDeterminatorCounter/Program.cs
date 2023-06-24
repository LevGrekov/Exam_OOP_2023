using MatrixDeterminatorCounter;

public static class Program
{ 

    public static void Main()
    {

        var dbh = DBHelper.GetInstance("localhost", 3306, "root", "", "matrix");

        var systemsWithNoAnswer = dbh.GetIdWithNullAnswer();

        if (systemsWithNoAnswer.Count != 0)
        {
            foreach (var systemID in systemsWithNoAnswer)
            {
                var matrix = dbh.getMatrix(systemID);
        

                var GS = MatrixDeterminantCalculator.CalculateDeterminant(matrix);
                dbh.UpdateAnswer(GS.ToString() , systemID);

            }
            Console.WriteLine("Успешно");
        }
        else
        {
            Console.WriteLine("Нерешенных Систем не обнаружено!");
        }


    }
}