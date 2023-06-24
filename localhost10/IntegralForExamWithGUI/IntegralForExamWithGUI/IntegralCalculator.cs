using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace IntegralForExamWithGUI
{
    public class Integral
    {
        private Func<double, double> function;
        private double lowerLim;
        private double upperLim;
        private int intervals;

        public double LowerLim => lowerLim;
        public double UpperLim => upperLim;
        public Func<double, double> Function => function;

        public Integral(Func<double, double> function,double lowerLim,double upperLim,int intervals)
        {
            this.function = function;
            this.lowerLim = lowerLim;
            this.upperLim = upperLim;
            this.intervals = intervals;
        }

        public double LeftRectangle()
        {
            var h = (upperLim - lowerLim) / intervals;
            var sum = 0d;
            for (var i = 0; i <= intervals - 1; i++)
            {
                var x = lowerLim + i * h;
                double y = function(x);
                if (double.IsNaN(y) || double.IsInfinity(y))
                {
                    continue;
                }
                    
                sum += y;
            }

            var result = h * sum;
            return result;
        }

        

    }
}
