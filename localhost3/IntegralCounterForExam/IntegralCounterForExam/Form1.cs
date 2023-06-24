namespace IntegralCounterForExam
{
    public partial class Form1 : Form
    {
        Integral integral;
        DBHelper dbHelper;
        public Form1()
        {
            dbHelper = DBHelper.GetInstance("localhost", 3306, "root", "", "SimsonIntegralDB");
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            double uplim = (double)numericUpDown1.Value;
            double lowlim = (double)numericUpDown2.Value;
            int intervals = (int)numericUpDown3.Value;
            integral = new Integral(lowlim, uplim, intervals);
            var answer = integral.Simpson();
            label5.Text = answer.ToString();

            dbHelper.InsertData(lowlim,uplim,intervals,answer,"x/(Sqrt(x)+1)");
        }
    }
}