
<?php
include 'connection.php';
$conn = getConnection();
try {
    if($_POST){
        $nama = $_POST["nama"];
        $nim = $_POST["nim"];
        $gender = $_POST["gender"];
        $kelas = $_POST["kelas"];
        $angkatan = $_POST["angkatan"];
        $semester = $_POST["semester"];
        $fakultas = $_POST["fakultas"];
        $jurusan = $_POST["jurusan"];
        $universitas = $_POST["universitas"];
        $foto = $_POST["foto"];

        if(isset($_FILES["foto"]["name"])){
            $image_name = $_FILES["foto"]["name"];
            $extensions = ["jpg", "png", "jpeg"];
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);
            
            if (in_array($extension, $extensions)){
                $upload_path = 'upload/' . $image_name;

                if(move_uploaded_file($_FILES["foto"]["tmp_name"], $upload_path)){

                    $foto = "http://localhost/mahasiswa/" . $upload_path; 

                    $statement = $conn->prepare("INSERT INTO `mahasiswa`( `nama`, `nim`, `gender`, `kelas`, `angkatan`, `semester`, `fakultas`, `jurusan`, `universitas`, `foto`) VALUES (:nama, :nim, :gender, :kelas, :angkatan, :semester, :fakultas, :jurusan, :universitas, :foto);");

                    $statement->bindParam(':nama', $nama);
                    $statement->bindParam(':nim',$nim);
                    $statement->bindParam(':gender',$gender);
                    $statement->bindParam(':kelas',$kelas);
                    $statement->bindParam(':angkatan',$angkatan);
                    $statement->bindParam(':semester', $semester);
                    $statement->bindParam(':fakultas',$fakultas);
                    $statement->bindParam(':jurusan',$jurusan);
                    $statement->bindParam(':universitas',$universitas);
                    $statement->bindParam(':foto',$foto);

                    $statement->execute();

                    $response["message"] = "Data berhasil diinput";
                    
                } else {
                    echo "gagal";
                }
            } else {
                $response["message"] = "Hanya diperbolehkan menginput gambar!";
            }

        } else {
            $statement = $conn->prepare("INSERT INTO `mahasiswa`( `nama`, `nim`, `gender`, `kelas`, `angkatan`, `semester`, `fakultas`, `jurusan`, `universitas`, `foto`) VALUES (:nama, :nim, :gender, :kelas, :angkatan, :semester, :fakultas, :jurusan, :universitas, :foto);");

            $statement->bindParam(':nama', $nama);
            $statement->bindParam(':jumlah',$jumlah);
            $statement->bindParam(':tanggal',$tanggal);
            $statement->bindParam(':nomor_hp',$nomor_hp);
            $statement->bindParam(':nama', $nama);
            $statement->bindParam(':nim',$nim);
            $statement->bindParam(':gender',$gender);
            $statement->bindParam(':kelas',$kelas);
            $statement->bindParam(':angkatan',$angkatan);
            $statement->bindParam(':semester', $semester);
            $statement->bindParam(':fakultas',$fakultas);
            $statement->bindParam(':jurusan',$jurusan);
            $statement->bindParam(':universitas',$universitas);
            $statement->bindParam(':foto',$foto);
          
            $statement->execute();
            $response["message"] = "Data berhasil diinput";
        }
    }
} catch (PDOException $e){
    $response["message"] = "error $e";
}
echo json_encode($response, JSON_PRETTY_PRINT);