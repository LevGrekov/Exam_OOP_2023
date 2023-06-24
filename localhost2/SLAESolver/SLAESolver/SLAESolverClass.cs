using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SLAESolver
{

    public class GaussSolver
    {
        private double[,] matrix;
        private double[] constants;
        private string? answer;

        public string? Answer => getAnswer();
        public GaussSolver(double[,] matrix, double[] constants)
        {
            this.matrix = matrix;
            this.constants = constants;
        }

        private double[]? Solve()
        {
            int n = constants.Length;
            double[] solution = new double[n];
            double[,] augmentedMatrix = AugmentMatrix(matrix, constants);

            for (int i = 0; i < n - 1; i++)
            {
                if (augmentedMatrix[i, i] == 0)
                {
                    return null;
                }

                for (int j = i + 1; j < n; j++)
                {
                    double factor = augmentedMatrix[j, i] / augmentedMatrix[i, i];
                    for (int k = i; k < n + 1; k++)
                    {
                        augmentedMatrix[j, k] -= factor * augmentedMatrix[i, k];
                    }
                }
            }

            for (int i = n - 1; i >= 0; i--)
            {
                double sum = 0;
                for (int j = i + 1; j < n; j++)
                {
                    sum += augmentedMatrix[i, j] * solution[j];
                }
                solution[i] = (augmentedMatrix[i, n] - sum) / augmentedMatrix[i, i];
            }

            return solution;
        }

        private static double[,] AugmentMatrix(double[,] matrix, double[] vector)
        {
            int n = vector.Length;
            double[,] augmentedMatrix = new double[n, n + 1];

            for (int i = 0; i < n; i++)
            {
                for (int j = 0; j < n; j++)
                {
                    augmentedMatrix[i, j] = matrix[i, j];
                }
                augmentedMatrix[i, n] = vector[i];
            }

            return augmentedMatrix;
        }

        private string? getAnswer()
        {
            if (matrix != null && constants != null)
            {

                var ans = Solve();

                if (ans != null)
                {
                    var sb = new StringBuilder();
                    for (int i = 1; i <= ans.Length; i++)
                    {
                        sb.Append($"x{i} = {Math.Round(ans[i - 1], 4)}, ");
                    }
                    return sb.ToString();
                }
                else return "Матрица Вырождена";              
            }
            else return null;
        }
    }


}
