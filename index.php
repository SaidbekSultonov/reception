<?php  

    $host = '127.0.0.1';
    $username = 'app_savravenue_user';
    $password = 'q^v1Azw#c%flLgEP';
    $database = 'app_savravenue_db';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $conn->exec("set names utf8mb4");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        global $conn;

    } 
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $stmt = $conn->prepare("SELECT id, first_name, last_name, middle_name  FROM users where deleted_at IS NULL and role_id = 3 ORDER BY id DESC");
    $stmt->execute();
    $users = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="images/logo.svg">
    <title>Savravenue | Reception</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-family: "Noto Sans KR", serif;
        }
        label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        input[type="checkbox"], input[type="radio"] {
            display: none;
        }
        .custom-box {
            width: 30px;
            height: 20px;
            border: 3px solid #FFE799;
            background-color: #FFFFFF;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bolder;
            color: transparent;
        }
        input:checked + .custom-box::after {
            content: "✓";
            color: #FFE799;
            font-size: 20px;
            font-weight: bolder;
        }
        .main_image img{
            width: 300px;
        }
        .p_1{
            font-family: Inter;
            font-size: 18px;
            font-weight: 400;
            line-height: 29.05px;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            margin-bottom: 5px;
        }
        .p_2{
            font-family: Inter;
            font-size: 18px;
            font-weight: 400;
            line-height: 29.05px;
            text-underline-position: from-font;
            text-decoration-skip-ink: none;
            margin-bottom: 5px;
        }
        .input_date{
            width: 100%;
            max-width: 200px;
            border: none;
            border-bottom: 2px solid;
            outline: none;
        }
        .input_fio{
            width: 100%;
            max-width: 400px;
            border: none;
            border-bottom: 2px solid;
            outline: none;
        }
        .input_ph{
            width: 100%;
            max-width: 400px;
            border: none;
            border-bottom: 2px solid;
            outline: none;
        }
        .back_fon{
            background: url('images/savr_back_logo.svg');
            background-position: center;
            background-size: 90%;
            background-repeat: no-repeat;
        }
        input{
            background: transparent;
        }
        #managers{
            width: 100%;
        }
        @media only screen and (max-width: 600px) {
          .main_image img {
            width: 170px;
          }
          .header_text h3{
            font-size: 18px;
          }
        }
    </style>
</head>
<body class="bg-light">
    <form class="container back_fon bg-white p-5 shadow" id="form">
        <div class="main_image text-center">
            <img src="images/savr_main_logo.svg" alt="" class="img-fluid">
        </div>

        <div class="header_text text-center">
            <h3 class="mt-3 mb-5">АНКЕТА ГОСТЯ</h3>
        </div>

        <div class="row">
            <div class="col-md-4 mb-2 mb-lg-0">
                <p class="p_1">Личные данные:</p>
            </div>
            <div class="col-md-8 text-lg-right">
                <div class="row">
                    <div class="col-8 text-lg-right">
                        <p class="p_2">Дата заполнения анкеты:</p>
                    </div>
                    <div class="col-4 text-lg-right">
                        <input type="date" class="input_date" id="date" name="date" value="<?= date('Y-m-d') ?>">
                    </div>
                    
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-2">
                        <p class="p_1">Ф.И.О:</p>
                    </div>
                    <div class="col-10">
                        <input type="text" class="input_fio" id="fullname" name="fullname">
                        <div>
                            <small class="d-none text-danger" id="error_fullname">Обязательное поле для заполнения</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 align-items-end">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-7 col-lg-4">
                        <p class="p_1">Контактные данные:</p>
                    </div>
                    <div class="col-5 col-lg-8">
                        <div class="d-flex">
                            <b>+998</b>
                            <input type="text" class="input_ph" id="inputs_ph" name="phone">
                        </div>
                        <div>
                            <small class="d-none text-danger" id="error_inputs_ph">Обязательное поле для заполнения</small>
                        </div>
                    </div>
                    
                </div>    
            </div>
            <div class="col-md-5">
                <div class="row align-items-end mt-3 mt-lg-0">
                    <div class="col-2">
                        <img src="images/telegram.svg" alt="" class="img-fluid">
                    </div>
                    <div class="col-10 pb-2">
                        <input type="text" class="input_ph" id="telegram" name="telegram">
                    </div>
                    
                </div>
            </div>
        </div>

        <h4 class="my-5">Откуда Вы о нас узнали?</h4>

        <div class="row">
            <div class="col-md-6">
                <div class="d-flex flex-column">
                    <label>
                        <input type="radio" class="radio_add" value="Telegram" name="radio-add">
                        <span class="custom-box"></span>
                        Telegram
                    </label>
                    <label>
                        <input type="radio" class="radio_add" value="Internet" name="radio-add">
                        <span class="custom-box"></span>
                        Internet
                    </label>
                    <label>
                        <input type="radio" class="radio_add" value="Instagram" name="radio-add">
                        <span class="custom-box"></span>
                        Instagram
                    </label>
                    <label>
                        <input type="radio" class="radio_add" value="Facebook" name="radio-add">
                        <span class="custom-box"></span>
                        Facebook
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex flex-column">
                    <label>
                        <input type="radio" class="radio_add" value="СМИ" name="radio-add">
                        <span class="custom-box"></span>
                        СМИ
                    </label>
                    <label>
                        <input type="radio" class="radio_add" value="Наружная реклама (баннер)" name="radio-add">
                        <span class="custom-box"></span>
                        Наружная реклама (баннер)
                    </label>
                    <label>
                        <input type="radio" class="radio_add" value="Через знакомых" name="radio-add">
                        <span class="custom-box"></span>
                        Через знакомых
                    </label>
                    <label>
                        <input type="radio" class="radio_add" value="Увидел(а) по дороге/Проходил(а) по дороге" name="radio-add">
                        <span class="custom-box"></span>
                        Увидел(а) по дороге/Проходил(а) по дороге
                    </label>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="d-flex justify-content-center align-items-end">
                    <label class="mb-0">
                        <input type="radio" name="radio-add" class="radio_add" id="other_radio">
                        <span class="custom-box"></span>
                        <span class="mr-2">Другое:</span>
                    </label>
                    <input type="text" class="input_ph" id="other_input">
                </div>
            </div>
        </div>

        <p class="p_1 mt-5">Сколько квадратов вы рассматриваете?:</p>
        <div class="row mt-3">
            <div class="col-12 col-md-6 col-lg-2">
                <label>
                    <input type="radio" name="radio-meter" class="radio_meter" value="28-35">
                    <span class="custom-box"></span>
                    28-35
                </label>
            </div>
            <div class="col-12 col-md-6 col-lg-2">
                <label>
                    <input type="radio" name="radio-meter" class="radio_meter" value="35-45">
                    <span class="custom-box"></span>
                    35-45
                </label>
            </div>
            <div class="col-12 col-md-6 col-lg-2">
                <label>
                    <input type="radio" name="radio-meter" class="radio_meter" value="44-54">
                    <span class="custom-box"></span>
                    44-54
                </label>
            </div>
            <div class="col-12 col-md-6 col-lg-2">
                <label>
                    <input type="radio" name="radio-meter" class="radio_meter" value="57-60">
                    <span class="custom-box"></span>
                    57-60
                </label>
            </div>
            <div class="col-12 col-md-6 col-lg-2">
                <label>
                    <input type="radio" name="radio-meter" class="radio_meter" value="60-77">
                    <span class="custom-box"></span>
                    60-77
                </label>
            </div>
        </div>

        <div class="row mt-lg-5 mt-3">
            <div class="col-md-4">
                <p class="p_1">Цель покупки:</p>
            </div>
            <div class="col-md-4">
                <label>
                    <input type="radio" name="radio-for" value="Для себя">
                    <span class="custom-box"></span>
                    Для себя
                </label>
            </div>
            <div class="col-md-4">
                <label>
                    <input type="radio" name="radio-for" value="Для инвестирования">
                    <span class="custom-box"></span>
                    Для инвестирования
                </label>
            </div>
        </div>
        

        <div class="row mt-lg-5 mt-3">
            <div class="col-12">
                <p class="p_1">Примечание:</p>
            </div>
            <div class="col-12">
                <textarea name="description" class="form-control"></textarea>
            </div>
        </div>

        <div class="row mt-lg-5 mt-3">
            <div class="col-md-4">
                <p class="p_1">Менеджер отдела продаж:</p>
            </div>
            <div class="col-md-8">
                <select name="manager" class="form-control" id="managers" data-placeholder="Выберите менеджера">
                    <option></option>
                    <?php if (!empty($users) && count($users) > 0): ?>
                        <?php foreach ($users as $key => $value): ?>
                            <option value="<?= $value['id'] ?>">
                                <?= $value['last_name'] ?> <?= $value['first_name'] ?> <?= $value['middle_name'] ?>
                            </option>                            
                        <?php endforeach ?>                        
                    <?php endif ?>
                    <option value="80">
                        Abduraxmanov Bekzod Ozod o`g`li
                      </option>
                </select>
                <div>
                    <small class="d-none text-danger" id="error_managers">Обязательное поле для заполнения</small>
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-md-3">
                <button type="button" id="button" class="btn btn-primary btn-block">Зарегистрировать</button>
            </div>
        </div>
    </form>
    <!-- Button trigger modal -->
   

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <img src="images/logo.svg" alt="">
            <h4>Savr Avenue</h4>
            <p class="p_1 mt-3">Ваша заявка получена.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $("#inputs_ph").inputmask("(99) 999-99-99");
            $('#managers').select2();
            // $('#exampleModal').modal('toggle')
        })

        $(document).on('keyup', '#other_input', function(){
            $('#other_radio').val($(this).val())
        })

        $(document).on('click', '#button', function(){
            var fullname = $('#fullname').val()
            var inputs_ph = $('#inputs_ph').val()
            var add = $('.radio_add:checked').val()
            var add = $('.radio_add:checked').val()
            var meter = $('.radio_meter:checked').val()
            var managers = $('#managers').val()
           

            if (fullname == '') {
                $('#fullname').addClass('border-danger')
                $('#error_fullname').removeClass('d-none')
            }
            else{
                $('#fullname').removeClass('border-danger')
                $('#error_fullname').addClass('d-none')
            }

            if (inputs_ph == '') {
                $('#inputs_ph').addClass('border-danger')
                $('#error_inputs_ph').removeClass('d-none')
            }
            else{
                $('#inputs_ph').removeClass('border-danger')
                $('#error_inputs_ph').addClass('d-none')
            }

            if (managers == 0) {
                $('#error_managers').removeClass('d-none')
            }
            else{
                $('#error_managers').addClass('d-none')
            }

            // if (add == '' || add == undefined) {
            //     alert('Откуда Вы о нас узнали ?')
            // }

            // if (meter == '' || meter == undefined) {
            //     alert('Сколько квадратов вы рассматриваете ?')
            // }
            



            if (fullname != '' && inputs_ph != '' && managers != 0) {
                $.ajax({
                    url: `send.php`,
                    data: $('#form').serialize(),
                    type: 'POST',
                    success: function(data) {
                        if (data == 'client_exist') {
                            alert('Данный номер телефона был ранее зарегистрирован!')
                        }
                        else if(data == 'client_not_saved'){
                            alert('Анкета не сохранена!')
                        }
                        else if(data == 'success') {
                            $('#exampleModal').modal('toggle')
                        }
                    },
                });    
            }
            else{
                alert('Вы не заполнили все поля.')
            }
            
        })

        $('#exampleModal').on('hidden.bs.modal', function () {
            location.reload()
        });
    </script>
</body>
</html>
