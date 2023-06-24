using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms.DataVisualization.Charting;

namespace IntegralForExamWithGUI
{
    internal class Painter
    {
        private Integral integral;
        private Chart chart;

        public Painter(Integral integral, Chart chart)
        {
            this.integral = integral;
            this.chart = chart;

            chart.Series.Clear();
            chart.ChartAreas.Clear();


            InitializeChart();
        }

        private void InitializeChart()
        {
            ChartArea chartArea = new ChartArea();
            chartArea.AxisX.Title = "X";
            chartArea.AxisY.Title = "Y";

            // Добавить разметку и настройки осей
            chartArea.AxisX.MajorGrid.Enabled = true;
            chartArea.AxisY.MajorGrid.Enabled = true;

            // Добавить разметку и настройки делений на осях
            chartArea.AxisX.MajorTickMark.Enabled = true;
            chartArea.AxisY.MajorTickMark.Enabled = true;

            chart.ChartAreas.Add(chartArea);

            // Добавление графика функции
            Series seriesFunction = new Series($"Integral");
            seriesFunction.ChartType = SeriesChartType.Spline;
            seriesFunction.Color = System.Drawing.Color.Blue;
            seriesFunction.BorderWidth = 3;

            double step = (integral.UpperLim - integral.LowerLim) / 1000; // Шаг для отрисовки графика функции
            for (double x = integral.LowerLim; x <= integral.UpperLim; x += step)
            {
                double y = integral.Function(x);
                seriesFunction.Points.AddXY(x, y);
            }

            chart.Series.Add(seriesFunction);

        }

        public byte[] GetChartBytes()
        {
            using (MemoryStream stream = new MemoryStream())
            {
                chart.SaveImage(stream, ChartImageFormat.Png); // Сохранение графика в формате PNG в потоке MemoryStream

                return stream.ToArray(); // Получение массива байтов из MemoryStream
            }
        }
    }
}
