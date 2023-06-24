namespace AnotherIntegralCounter
{
    public partial class Form1 : Form
    {
        Integral integral;
        string url = "http://localhost4/createFile.php";
        public Form1()
        {
            InitializeComponent();
        }

       

        private async void button1_Click(object sender, EventArgs e)
        {
            double uplim = (double)numericUpDown1.Value;
            double lowlim = (double)numericUpDown2.Value;
            int intervals = (int)numericUpDown3.Value;
            integral = new Integral(lowlim, uplim, intervals);
            var answer = integral.Simpson();
            label5.Text = answer.ToString();

            string parameters = $"?upperLimit={uplim}&lowerLimit={lowlim}&intervals={intervals}&answer={answer}";
            await Send(url,parameters);
            
        }

        private async Task Send(string url, string parameters) => await HttpHelper.SendData(url, parameters);
    }
}