<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>台中教育大學＿碩博班報名系統</title>
    <script src="{{asset("lib/jquery-3.2.1.min.js")}}"></script>
    <script src="index.js"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/index.css')}}">

</head>

<body>

<div class="form">

    <form action="{{url('upload')}}" method="post" name="Form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table border="0">
            <tr>
                <td>
                    <span style="color: red">＊</span> 姓名：
                </td>
                <td>
                    <input type="text" id="name" name="name" size="20">
                </td>
            </tr>
            <tr>
                <td>
                    <span>&nbsp;&nbsp;&nbsp;</span> 大頭照：
                </td>
                <td>
                    <input type="file" id="photo" name="photo"
                           accept="image/jpeg,image/jpg,image/gif,image/png">
                    <!--                    accept="image/jpeg,image/jpg,image/gif,image/png" 限制上傳檔案類型-->
                </td>
            </tr>
            <tr>
                <td>
                    <span style="color: red">＊</span> 性別：
                </td>
                <td>
                    <input type="radio" name="gender" value="男" checked="checked">男
                    <input type="radio" name="gender" value="女">女
                </td>
            </tr>
            <tr>
                <td>
                    <span style="color: red">＊</span> 出生：
                </td>
                <td>
                    <input type="date" name="birthday" value="1997-01-01" min="1900-01-01" max="9999/12/31">
                </td>
            </tr>
            <tr>
                <td>
                    <span style="color: red">＊</span> 身分證：
                </td>
                <td>
                    <input type="text" name="id" size="20">
                </td>
            </tr>
            <tr>
                <td>
                    <span>&nbsp;&nbsp;&nbsp;</span> 行動電話：
                </td>
                <td>
                    <input type="number" name="phone" size="20" placeholder="輸入數字">
                </td>
            </tr>
            <tr>
                <td>
                    <span>&nbsp;&nbsp;&nbsp;</span> 地址：
                </td>
                <td>

                    <!--                    <input type="text" id="zip_code" name="zip_code" size="4">-->
                    <span id="zip_code"></span>
                    <?php
                    /*
                $city_search = "SELECT CityName FROM Institute_Registration.address group by CityName order by id asc;";
                $city_data = DBconnect::connect()->query($city_search);
                */
                    ?>

                    <select id="city_name" name="city_name">
                        <option value="city_name_null">請選擇縣市</option>
                        <?php
                        /*
                    foreach ($city_data as $value) {
                        echo "<option value=" . $value['CityName'] . ">" . $value['CityName'] . "</option>";
                    }
                        */
                        ?>
                    </select>
                    <select id="area_name" name="area_name">
                        <option value="area_name_null">請選擇區</option>
                    </select>


                    <input type="text" name="address" size="60">
                </td>
            </tr>
            <tr>
                <td>
                    <span>&nbsp;&nbsp;&nbsp;</span> Email:
                </td>
                <td>
                    <input type="email" name="email">
                </td>
            </tr>
            <tr>
                <td>
                    <span style="color: red">＊</span> 畢業學校和系所：
                </td>
                <td>
                    <select id="school" name="school">
                        <option value="school_null">請選擇畢業學校</option>
                        <?php
                        /*
                    // 找學校名稱
                    $school = new School();
                    foreach ($school->school_search() as $value) {
                        echo $value['school_name'] . '<br>';
                        echo "  <option value=" . $value['school_name'] . ">" . $value['school_name'] . "</option>";
                    }
                        */
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="color: red">＊</span> 請選擇畢業科系：
                </td>
                <td>
                    <select id="school_department" name="school_department">
                        <option value="school_department_null">畢業科系</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="color: red">＊</span> 報考科系：

                </td>
                <td>
                    <select name="ntcu_department">
                        <option value="ntcu_department_null">請選擇報考科系</option>
                        @foreach($NTCUDepartment as $value)
                            <option value={{$value->department_id}}>{{$value->department_name}}</option>
                        @endforeach
                        <?php
                        /*
                    // 找本校學校碩博班科系
                    $ntcu_department = new NTCUDepartment();
                    foreach ($ntcu_department->NTCU_department_search() as $value) {
                        echo "  <option value=" . $value['department_id'] . ">" . $value['department_name'] . "</option>";
                    }
                        */
                        ?>


                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" value="送出" OnClick="CheckInput();">
        <input type="reset" value="清除">

    </form>
</div>
<script>

    // $(document).ready(function () {
    //     $("#city_name").change(function () {
    //         console.log($("#city_name").val());
    //         $.post("ajax/AreaName.php",
    //             {
    //                 cityName: $("#city_name").val()
    //             }
    //             , function (data) {
    //                 $("#area_name").empty();// 移除下拉式選單html
    //                 // 尋找到地區和郵遞區號(json格式)
    //
    //                 $.each(JSON.parse(data), function (index, value) {
    //                     $("#area_name").append
    //                     ("<option value=" + index + ">" + value + "</option>");
    //
    //                 });
    //
    //             });
    //     });
    // });


</script>
</body>

</html>

