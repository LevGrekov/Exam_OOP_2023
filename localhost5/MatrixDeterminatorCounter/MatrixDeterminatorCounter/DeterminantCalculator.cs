using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MatrixDeterminatorCounter
{
    public static class MatrixDeterminantCalculator
    {
        public static double CalculateDeterminant(double[,] matrix)
        {
            int rows = matrix.GetLength(0);
            int cols = matrix.GetLength(1);

            if (rows != cols)
            {
                throw new ArgumentException("Матрица должна быть квадратной");
            }

            double determinant = 1.0;

            for (int i = 0; i < rows - 1; i++)
            {
                if (matrix[i, i] == 0)
                {
                    bool rowSwapped = false;

                    for (int j = i + 1; j < rows; j++)
                    {
                        if (matrix[j, i] != 0)
                        {
                            SwapRows(matrix, i, j);
                            determinant *= -1;
                            rowSwapped = true;
                            break;
                        }
                    }

                    if (!rowSwapped)
                    {
                        return 0.0; // Матрица вырожденная, определитель равен 0
                    }
                }

                for (int j = i + 1; j < rows; j++)
                {
                    double factor = matrix[j, i] / matrix[i, i];

                    for (int k = i; k < cols; k++)
                    {
                        matrix[j, k] -= factor * matrix[i, k];
                    }
                }

                determinant *= matrix[i, i];
            }

            determinant *= matrix[rows - 1, rows - 1];
            return determinant;
        }

        private static void SwapRows(double[,] matrix, int row1, int row2)
        {
            int cols = matrix.GetLength(1);

            for (int i = 0; i < cols; i++)
            {
                double temp = matrix[row1, i];
                matrix[row1, i] = matrix[row2, i];
                matrix[row2, i] = temp;
            }
        }
    }
}
