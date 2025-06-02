# Create directories if they don't exist
$directories = @(
    "public/template/css",
    "public/template/js",
    "public/template/images",
    "public/template/colors"
)

foreach ($dir in $directories) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Force -Path $dir
    }
}

# Copy CSS files from AdminLTE
Copy-Item "template/AdminLTE-3.2.0/dist/css/adminlte.min.css" -Destination "public/template/css/bootstrap.min.css" -Force
Copy-Item "template/AdminLTE-3.2.0/dist/css/adminlte.min.css" -Destination "public/template/css/style.css" -Force
Copy-Item "template/AdminLTE-3.2.0/dist/css/adminlte.min.css" -Destination "public/template/css/dark-style.css" -Force
Copy-Item "template/AdminLTE-3.2.0/dist/css/adminlte.min.css" -Destination "public/template/css/transparent-style.css" -Force
Copy-Item "template/AdminLTE-3.2.0/dist/css/adminlte.min.css" -Destination "public/template/css/skin-modes.css" -Force

# Copy Font Awesome for icons
Copy-Item "template/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css" -Destination "public/template/css/icons.css" -Force
Copy-Item "template/AdminLTE-3.2.0/plugins/fontawesome-free/webfonts/*" -Destination "public/template/webfonts/" -Force

# Copy JS files
Copy-Item "template/AdminLTE-3.2.0/plugins/jquery/jquery.min.js" -Destination "public/template/js/jquery.min.js" -Force
Copy-Item "template/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js" -Destination "public/template/js/bootstrap.min.js" -Force
Copy-Item "template/AdminLTE-3.2.0/plugins/popper/popper.min.js" -Destination "public/template/js/popper.min.js" -Force
Copy-Item "template/AdminLTE-3.2.0/dist/js/adminlte.min.js" -Destination "public/template/js/sticky.js" -Force
Copy-Item "template/AdminLTE-3.2.0/dist/js/adminlte.min.js" -Destination "public/template/js/sidemenu.js" -Force
Copy-Item "template/AdminLTE-3.2.0/dist/js/adminlte.min.js" -Destination "public/template/js/sidebar.js" -Force

# Copy color files
Copy-Item "template/AdminLTE-3.2.0/dist/css/adminlte.min.css" -Destination "public/template/colors/color1.css" -Force

Write-Host "Template files have been copied successfully!"
