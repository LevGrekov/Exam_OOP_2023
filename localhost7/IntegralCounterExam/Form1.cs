namespace IntegralCounterExam
{
    public partial class Form1 : Form
    {
        DBHelper dbHelper;
        RectangleMethodCalculator integral;
        public Form1()
        {
            dbHelper = DBHelper.GetInstance("localhost", 3306, "root", "", "IntegralExam");
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            double uplim = (double)numericUpDown1.Value;
            double lowlim = (double)numericUpDown2.Value;
            int intervals = (int)numericUpDown3.Value;
            integral = new RectangleMethodCalculator( x => 3/Math.Pow(Math.Sqrt((3+Math.Pow(x,2))),3));
            var answer = integral.CalculateIntegral(uplim,lowlim,intervals);
            label5.Text = answer.ToString();
            dbHelper.InsertData(lowlim, uplim, intervals, answer, "3/sqrt(3+x^2)^3");
        }

    }
}