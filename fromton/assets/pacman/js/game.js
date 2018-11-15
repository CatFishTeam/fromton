function Game(container, ms)
{
    this.container = $(container).get(0),
    this.ms = ms,
    this.width = this.container.width,
    this.height = this.container.height,
    this.ctx = this.container.getContext("2d"),
    this.play = true,

    this.rightDown = false,
    this.leftDown = false,
    this.topDown = false,
    this.bottomDown = false,
    this.spaceDown = false,

    this.init = function()
    {
        this.initKeys();
        setInterval(this.mainLoop, this.ms);
    },

    this.initKeys = function()
    {
        $(document).keydown(function(e) {
            if (game.play === true)
            {
                if (e.keyCode === 39)
                    game.rightDown = true;
                else if (e.keyCode === 37)
                    game.leftDown = true;
                else if (e.keyCode === 38)
                    game.topDown = true;
                else if (e.keyCode === 40)
                    game.bottomDown = true;
            }
        });

        $(document).keyup(function(e) {
            if (game.play === true)
            {
                if (e.keyCode === 39)
                    game.rightDown = false;
                else if (e.keyCode === 37)
                    game.leftDown = false;
                else if (e.keyCode === 38)
                    game.topDown = false;
                else if (e.keyCode === 40)
                    game.bottomDown = false;
            }
        });
    },

    this.mainLoop = function()
    {
        if (game.play === true)
        {
            game.ctx.clearRect(0, 0, game.width, game.height);

            firstLevel.generate();

            player.create("/build/pacman/images/pacman.png");
            player.move();

            redGhost.create("/build/pacman/images/mouse.png");
            redGhost.move(2);

            blueGhost.create("/build/pacman/images/mouse.png");
            blueGhost.move(3);

            yellowGhost.create("/build/pacman/images/mouse.png");
            yellowGhost.move(2);

            pinkGhost.create("/build/pacman/images/mouse.png");
            pinkGhost.move(3);

            $("#score").html(player.score);

            if (player.score >= 1910)
            {
                alert("TU AS GAGNE !");
                game.play = false;
            }
        }
        game.keyManager();
    },

    this.keyManager = function()
    {
        if (game.rightDown)
            player.direction = 0;
        if (game.leftDown)
            player.direction = 1;
        if (game.topDown)
            player.direction = 2;
        if (game.bottomDown)
            player.direction = 3;
    };
}

var game = new Game("canvas", 24),
    player = new Player(76, 76, 1, 1, "#3498DB"),
    redGhost = new Ghost(76, 76, 9, 10, "#FF0000"),
    blueGhost = new Ghost(76, 76, 9, 10, "#0000FF"),
    yellowGhost = new Ghost(76, 76, 9, 10, "#FFFF00"),
    pinkGhost = new Ghost(76, 76, 9, 10, "#FF00FF"),
    food = new Food(2),
    firstLevel = new Map(firstMap, 30);

game.init();