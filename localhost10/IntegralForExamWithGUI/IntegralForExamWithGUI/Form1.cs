using System.Windows.Forms;

namespace IntegralForExamWithGUI
{
    public partial class IntegralCounter : Form
    {
        private DBHelper dbHelper;
        private Integral integral;
        private Painter painter;

        private Func<double, double> function = x => Math.Pow(Math.E,x/3);
        public IntegralCounter()
        {
            dbHelper = DBHelper.GetInstance("localhost", 3306, "root", "");
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            double uplim = (double)numericUpDown1.Value;
            double lowlim = (double)numericUpDown2.Value;
            int intervals = (int)numericUpDown3.Value;
            integral = new Integral(function, lowlim, uplim, intervals);
            var answer = Math.Round(integral.LeftRectangle(), 5);

            painter = new Painter(integral, chart1);

            label5.Text = answer.ToString();

            byte[] Image = painter.GetChartBytes();
            
            dbHelper.InsertData(Image);
        }

    }
}