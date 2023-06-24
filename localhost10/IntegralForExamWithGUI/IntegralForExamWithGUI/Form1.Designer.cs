using static System.Net.Mime.MediaTypeNames;
using System.Windows.Forms;
using System.Xml.Linq;

namespace IntegralForExamWithGUI
{
    partial class IntegralCounter
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            System.Windows.Forms.DataVisualization.Charting.ChartArea chartArea1 = new System.Windows.Forms.DataVisualization.Charting.ChartArea();
            System.Windows.Forms.DataVisualization.Charting.Legend legend1 = new System.Windows.Forms.DataVisualization.Charting.Legend();
            label1 = new Label();
            label2 = new Label();
            numericUpDown1 = new NumericUpDown();
            numericUpDown2 = new NumericUpDown();
            numericUpDown3 = new NumericUpDown();
            label3 = new Label();
            label4 = new Label();
            label5 = new Label();
            button1 = new Button();
            chart1 = new System.Windows.Forms.DataVisualization.Charting.Chart();
            label6 = new Label();
            label7 = new Label();
            ((System.ComponentModel.ISupportInitialize)numericUpDown1).BeginInit();
            ((System.ComponentModel.ISupportInitialize)numericUpDown2).BeginInit();
            ((System.ComponentModel.ISupportInitialize)numericUpDown3).BeginInit();
            ((System.ComponentModel.ISupportInitialize)chart1).BeginInit();
            SuspendLayout();
            // 
            // label1
            // 
            label1.AutoSize = true;
            label1.Location = new Point(132, 53);
            label1.Name = "label1";
            label1.Size = new Size(143, 25);
            label1.TabIndex = 3;
            label1.Text = "Верхний предел";
            // 
            // label2
            // 
            label2.AutoSize = true;
            label2.Location = new Point(132, 180);
            label2.Name = "label2";
            label2.Size = new Size(141, 25);
            label2.TabIndex = 4;
            label2.Text = "Нижний предел";
            // 
            // numericUpDown1
            // 
            numericUpDown1.Location = new Point(29, 53);
            numericUpDown1.Maximum = new decimal(new int[] { 10000, 0, 0, 0 });
            numericUpDown1.Name = "numericUpDown1";
            numericUpDown1.Size = new Size(97, 31);
            numericUpDown1.TabIndex = 5;
            numericUpDown1.Value = new decimal(new int[] { 10, 0, 0, 0 });
            // 
            // numericUpDown2
            // 
            numericUpDown2.Location = new Point(29, 174);
            numericUpDown2.Maximum = new decimal(new int[] { 10000, 0, 0, 0 });
            numericUpDown2.Minimum = new decimal(new int[] { 10000, 0, 0, int.MinValue });
            numericUpDown2.Name = "numericUpDown2";
            numericUpDown2.Size = new Size(97, 31);
            numericUpDown2.TabIndex = 6;
            // 
            // numericUpDown3
            // 
            numericUpDown3.Location = new Point(29, 243);
            numericUpDown3.Maximum = new decimal(new int[] { 2000000, 0, 0, 0 });
            numericUpDown3.Minimum = new decimal(new int[] { 1, 0, 0, 0 });
            numericUpDown3.Name = "numericUpDown3";
            numericUpDown3.Size = new Size(180, 31);
            numericUpDown3.TabIndex = 7;
            numericUpDown3.Value = new decimal(new int[] { 2000, 0, 0, 0 });
            // 
            // label3
            // 
            label3.AutoSize = true;
            label3.Location = new Point(29, 277);
            label3.Name = "label3";
            label3.Size = new Size(174, 25);
            label3.TabIndex = 8;
            label3.Text = "Кол-во Интервалов";
            // 
            // label4
            // 
            label4.AutoSize = true;
            label4.Location = new Point(228, 122);
            label4.Name = "label4";
            label4.Size = new Size(24, 25);
            label4.TabIndex = 9;
            label4.Text = "=";
            // 
            // label5
            // 
            label5.BackColor = SystemColors.ActiveBorder;
            label5.Font = new Font("Segoe UI", 15F, FontStyle.Regular, GraphicsUnit.Point);
            label5.Location = new Point(258, 118);
            label5.Name = "label5";
            label5.Size = new Size(143, 41);
            label5.TabIndex = 10;
            // 
            // button1
            // 
            button1.Location = new Point(258, 243);
            button1.Name = "button1";
            button1.Size = new Size(143, 34);
            button1.TabIndex = 11;
            button1.Text = "Подсчитать";
            button1.UseVisualStyleBackColor = true;
            button1.Click += button1_Click;
            // 
            // chart1
            // 
            chartArea1.Name = "ChartArea1";
            chart1.ChartAreas.Add(chartArea1);
            legend1.Enabled = false;
            legend1.Name = "Legend1";
            chart1.Legends.Add(legend1);
            chart1.Location = new Point(423, 53);
            chart1.Name = "chart1";
            chart1.Size = new Size(616, 362);
            chart1.TabIndex = 12;
            chart1.Text = "chart1";
            // 
            // label6
            // 
            label6.Font = new Font("Segoe UI", 30F, FontStyle.Regular, GraphicsUnit.Point);
            label6.Location = new Point(29, 87);
            label6.Name = "label6";
            label6.Size = new Size(54, 72);
            label6.TabIndex = 13;
            label6.Text = "I";
            // 
            // label7
            // 
            label7.AutoSize = true;
            label7.Location = new Point(68, 122);
            label7.Name = "label7";
            label7.Size = new Size(162, 25);
            label7.TabIndex = 14;
            label7.Text = "Your Function(x) dx";
            // 
            // IntegralCounter
            // 
            AutoScaleDimensions = new SizeF(10F, 25F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1090, 450);
            Controls.Add(label7);
            Controls.Add(label6);
            Controls.Add(chart1);
            Controls.Add(button1);
            Controls.Add(label5);
            Controls.Add(label4);
            Controls.Add(label3);
            Controls.Add(numericUpDown3);
            Controls.Add(numericUpDown2);
            Controls.Add(numericUpDown1);
            Controls.Add(label2);
            Controls.Add(label1);
            Name = "IntegralCounter";
            Text = "Form1";
            ((System.ComponentModel.ISupportInitialize)numericUpDown1).EndInit();
            ((System.ComponentModel.ISupportInitialize)numericUpDown2).EndInit();
            ((System.ComponentModel.ISupportInitialize)numericUpDown3).EndInit();
            ((System.ComponentModel.ISupportInitialize)chart1).EndInit();
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion
        private Label label1;
        private Label label2;
        private NumericUpDown numericUpDown1;
        private NumericUpDown numericUpDown2;
        private NumericUpDown numericUpDown3;
        private Label label3;
        private Label label4;
        private Label label5;
        private Button button1;
        private System.Windows.Forms.DataVisualization.Charting.Chart chart1;
        private Label label6;
        private Label label7;
    }
}

