using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace AnotherIntegralCounter
{
    public static class HttpHelper
    {
        public static async Task SendData(string url, string parameters)
        {
            var client = new HttpClient();

            var response = await client.GetAsync(url + parameters);
            var responseString = await response.Content.ReadAsStringAsync();

            Debug.WriteLine(responseString);
            Console.WriteLine(responseString);
        }
    }
}
