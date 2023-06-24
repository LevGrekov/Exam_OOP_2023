using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace AnotherIntegralCounter
{
    delegate double Function(double x);
    public class Integral
    {
        private Function function;
        private readonly double upperLimit;
        private readonly double lowerLimit;
        private readonly int intervals = 2000;

        public Integral(double lowerLimit, double upperLimit, int intervals)//, string function)
        {
            if (lowerLimit > upperLimit)
            {
                var temp = upperLimit;
                upperLimit = lowerLimit;
                lowerLimit = temp;
            }

            this.upperLimit = upperLimit;
            this.lowerLimit = lowerLimit;
            this.intervals = intervals;
            this.function = x => (Math.Sqrt(4 * (1 + Math.Pow(x,2))/16));
        }

        public double Simpson()
        {
            var h = (upperLimit - lowerLimit) / intervals;
            var sum1 = 0d;
            var sum2 = 0d;
            object locker = new object();

            Parallel.For(1, intervals, new ParallelOptions { MaxDegreeOfParallelism = Environment.ProcessorCount }, k =>
            {
                var xk = lowerLimit + k * h;
                if (k <= intervals - 1)
                {
                    lock (locker)
                    {
                        sum1 += function(xk);
                    }
                }

                var xk_1 = lowerLimit + (k - 1) * h;

                lock (locker)
                {
                    sum2 += function((xk + xk_1) / 2);
                }
            });

            var result = h / 3d * (1d / 2d * function(lowerLimit) + sum1 + 2 * sum2 + 1d / 2d * function(upperLimit));
            return result;

        }


    }
}
