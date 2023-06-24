using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace IntegralCounterExam
{
    public class RectangleMethodCalculator
    {
        private Func<double, double> function;

        public RectangleMethodCalculator(Func<double, double> function)
        {
            this.function = function;
        }

        public double CalculateIntegral(double a, double b, int n)
        {
            double h = (b - a) / n;
            double sum = 0;

            for (int i = 0; i < n; i++)
            {
                double x = a + (i + 0.5) * h;
                sum += function(x);
            }

            return h * sum;
        }
    }
}
