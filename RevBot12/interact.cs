using System;
using System.Diagnostics;

namespace RevBot1
{
    internal class interact
    {
        public static string type = "close";

        public static void Run()
        {
            if (type == "close")
            {
                Close();
            }
            else if (type == "uninstall")
            {
                Uninstall();
            }
        }

        private static void Close()
        {
            // Code pour fermer le logiciel
            Console.WriteLine("Fermeture du logiciel...");
            // Ferme le programme en cours
            Environment.Exit(0);
        }

        private static void Uninstall()
        {
            // Code pour fermer et supprimer le programme
            Console.WriteLine("Fermeture et suppression du programme...");
            // Ferme le programme en cours
            Environment.Exit(0);

            // Chemin d'accès du fichier exécutable du programme en cours
            string executablePath = Process.GetCurrentProcess().MainModule.FileName;

            // Lancer un processus externe pour supprimer le fichier exécutable
            ProcessStartInfo psi = new ProcessStartInfo();
            psi.FileName = "cmd.exe";
            psi.Arguments = $"/c timeout 5 & del \"{executablePath}\"";
            psi.WindowStyle = ProcessWindowStyle.Hidden;
            Process.Start(psi);
        }
    }
}
