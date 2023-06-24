namespace SLAUExam
{
    static class Program
    {
        public static void Main()
        {

            var dbh = DBHelper.GetInstance("localhost", 3306, "root", "", "examtest");

            Console.WriteLine("Укажите ваш login");
            var login = Console.ReadLine().Trim();

            var systemsWithNoAnswer = dbh.GetIdWithNullAnswer(login);

            if (systemsWithNoAnswer.Count != 0)
            {
                foreach (var systemID in systemsWithNoAnswer)
                {
                    var matrix = dbh.getMatrix(systemID);
                    var constants = dbh.getConstants(systemID);

                    var GS = new GaussSolver(matrix, constants);
                    dbh.UpdateAnswer(GS.Answer ?? "Ошибка", systemID);

                }
                Console.WriteLine("Все нерешенные матрицы решены!");
            }
            else
            {
                Console.WriteLine("Нерешенных Систем не обнаружено!");
            }


        }

    }
}