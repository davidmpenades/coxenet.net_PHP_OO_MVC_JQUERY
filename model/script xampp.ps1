Add-Type -AssemblyName PresentationCore,PresentationFramework

# Ventana de bienvenida
$ownerName = "CAPITANHOMER"
$welcomeMessage = "Bienvenido, vamos a solucionar el problema de xampp donde se cierra mysql. Ejecútelo bajo su responsabilidad. Se creará una carpeta 'backup-script' donde se guardarán las carpetas como antes de ejecutar el script. ¿Desea continuar?"
$backupDir = "C:\xampp\mysql\backup-script"
$confirm = [System.Windows.MessageBox]::Show($welcomeMessage, $ownerName, [System.Windows.MessageBoxButton]::OKCancel)

if($confirm -eq "Cancel") {
    exit
}

# Creamos carpeta para la copia de seguridad
New-Item -ItemType Directory -Path $backupDir -ErrorAction SilentlyContinue

# Borramos data-old, si existe, para evitar problemas

# Hacemos copia de seguridad de la carpeta mysql
Copy-Item -Path "C:\xampp\mysql\*" -Destination "$backupDir" -Recurse -Force -ErrorAction SilentlyContinue

# Renombramos la carpeta data
Rename-Item -Path "C:\xampp\mysql\data" -NewName "data-old"

# Creamos carpeta nueva data
New-Item -ItemType Directory -Path "C:\xampp\mysql\data"

# Copiamos los datos de la carpeta backup a data
Copy-Item -Path "C:\xampp\mysql\backup\*" -Destination "C:\xampp\mysql\data" -Recurse -Force -ErrorAction SilentlyContinue

# Copiamos el archivo ibdata1 de data-old a data
Copy-Item -Path "C:\xampp\mysql\data-old\ibdata1" -Destination "C:\xampp\mysql\data" -ErrorAction SilentlyContinue

# Copiamos las carpetas de data-old a data, menos las carpetas mysql, performance_schema,phpmyadmin
Get-ChildItem -Path "C:\xampp\mysql\data-old\" -Directory | 
Where-Object { $_.Name -notin @("mysql", "performance_schema", "phpmyadmin") } |
ForEach-Object { Copy-Item -Path $_.FullName -Destination "C:\xampp\mysql\data" -Recurse -Force }

# Vamos a copiar los procedures almacenados

# Borramos data-old

# Ventana de confirmación
$successMessage = "El script se ha ejecutado correctamente. Gracias por confiar en CAPITANHOMER."
[System.Windows.MessageBox]::Show($successMessage, $ownerName)

exit
