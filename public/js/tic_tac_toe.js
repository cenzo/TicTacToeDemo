console.log("loaded");

$(document).ready(function() {
    let boardComplete = false;
    clearBoard();

    function setNextMove($nextMove) {
        let boxPosition = ($nextMove[0]+1) + ($nextMove[1]*3);
        let box = $("#box_"+boxPosition);
        let input = box.children();

        box.addClass("o_unit");
        input.val('O');
    }

    $(".box").click(function() {
        if(boardComplete)
            return;

        let input = $(this).children();

        if (input.val() != "X"  && input.val() != "O")
        {
            input.val("X")
            $(this).addClass("x_unit");

            $("form#game").submit();
        }
    });

    $("form#game").submit(function (e) {
        e.preventDefault();
        let row = [];
        let board = [];
        let playerUnit = "";
        let i = 1;
        let data = $(this).serializeArray();
        data.map(
            function(x){
                if (x.name == "playerUnit") {
                    playerUnit = x.value;
                    return;
                }
                row.push(x.value);
                if (i%3 == 0)
                {
                    board.push(row);
                    row = [];
                }
                ++i;
            });


        let req ={}
        req.playerUnit = playerUnit;
        req.board  = board;

        console.log(JSON.stringify(req));

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../index.php/game/move",
            data: JSON.stringify(req),
            contentType: "application/json; charset=utf-8",
            async: true,
            success: function(data){
                console.log("success");
                console.log(data);
                setNextMove(data["nextMove"]);
                boardComplete = data["gameCompleted"];
                $("#messages").html(data["message"]);
            },
            error: function(e){
                $("#messages").html(e);
                console.log(e);
            }
        });

    });

});


function clearBoard()
{
    $('.box').children().val('');
}