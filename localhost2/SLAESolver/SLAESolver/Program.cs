using SLAESolver;
using System.Numerics;

static class Program
{
    public static void Main()
    {

        var dbh = DBHelper.GetInstance("localhost",3306,"root","","slaedb");

        var systemsWithNoAnswer = dbh.GetIdWithNullAnswer();

        if (systemsWithNoAnswer.Count != 0)
        {
            foreach (var systemID in systemsWithNoAnswer)
            {
                var matrix = dbh.getMatrix(systemID);
                var constants = dbh.getConstants(systemID);

                var GS = new GaussSolver(matrix, constants);
                dbh.UpdateAnswer(GS.Answer ?? "Ошибка", systemID);

            }
            Console.WriteLine("Успешно");
        }
        else
        {
            Console.WriteLine("Нерешенных Систем не обнаружено!");
        }

        
    }

}
