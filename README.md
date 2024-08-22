<div align="center">
<img src="https://github.com/helenzina/Game-Generator/blob/main/advancedboard.jpg"/>
<h3 align="center">Board Game Generator</h3>
<p align="center">
In terminal Using Java
<br/>
<br/>
<a href="https://github.com/helenzina/Game-Generator"><strong>Explore the docs</strong></a>
</p>
</div>

 ### Built With

This project was built with the following:
- <a href="https://www.java.com/en/">Java</a>.
- <a href="https://www.jetbrains.com/idea/download/?section=windows">IntelliJ Community IDEA</a> for the IDE.


 ## About The Project
 
<p align="center">
<img src="https://github.com/helenzina/Game-Generator/blob/main/run.gif"  title="run"/>
</p>

The Board Game Generator project is a versatile tool empowers users to create unique and customizable board games with minimal effort. Designed with flexibility in mind, the Board Game Generator leverages the factory design pattern, allowing for extensive customization and reusability.

## What It Does

The Board Game Generator allows you to:

1. **Create Custom Game Elements:**

   - Dice: Customize the dice values as m.
   - Cards: Design your own cards with specific attributes and abilities.
   - Tiles: Generate tiles that can have special abilities or effects, enhancing gameplay dynamics.
   - Dashboards: Create various dashboards for different types of games and players.

2. **Have Access To Already Installed Dashboards:**

   - Limited Dashboard: Similar to games like "Snake", where the game has a defined end point.
   - Endless Dashboard: Similar to games like "Monopoly", circular game boards where the game continues until a certain condition is met, such as:
      - A player reaching a high amount of points.
      - A specified number of game rounds being completed.

3. **Have Access To Already Installed Board Game Types:**

   - Simple Board Game:
      - Players move forward or backward based on the tile value (positive or negative).
      - The game ends when a player reaches the exact end of the board.
   - Advanced Board Game:
      - The game ends based on points or rounds conditions.
      - Includes complex tiles with various effects, and the addition of cards.
      - Players earn extra points when passing the starting point/tile, though this can be easily adjusted, like any other tile or card.


4. **Save and Reload Games:**

   - Persistence: Save your game progress and reload it at any time. This feature ensures that your game can be continued even after a crash or shutdown, providing a seamless gaming experience. If you forget to save it, don't worry because it's automatically saved anyway.
   - JSON Format: Game specifications are stored and saved in JSON format, making it easy to manage and modify game data.

5. **Create Your Own Game:**

   - Combine all of the above features to create your own unique game. Initialize your own game based on the example.json to run properly. The "Simple" board game type can act the same as the "Advanced" due to the Factory Design Pattern. In the Factory pattern, we create objects without exposing the creation logic to the client and refer to the newly created object using a common interface. In other words, you create a new class and call it a new board type, tile, or card.


## Getting Started
 
 ### Installation
 
<p>Please follow the following steps for successful installation:</p>

1. Install <a href="https://www.jetbrains.com/idea/download/?section=windows">IntelliJ Community IDEA</a>. 
   
2. Clone the repo
   ```sh
   gh repo clone helenzina/Game-Generator
   ```

## Features

- **Factory Design Pattern**: Enhances code reusability and scalability, allowing for easy addition of new game elements and rules.
- **Customizability**: Code reusability allows everyone to make their own board games and modify them easily.
- **Randomization**: Add random elements to increase replayability and surprise.
- **User-Friendly Interface**: Intuitive design that makes game creation accessible to everyone, regardless of programming knowledge.
- **Import/Export Option**: Load and save your games in JSON format for adjusting your game specifications easily.
- **Validation**: Secure the best experience by using exceptions and other checks to prevent the game from crashing, ensuring smooth gameplay.

## How To Run

### Using IntelliJ Community IDEA

To run Game Generator, follow these steps:

Open the folder of your local repository in IntelliJ Community IDEA and select a version of JDK for the compiler to run it.


### Using Visual Studio Code

To run Game Generator, follow these steps:

1. Open the folder of your local repository in Visual Studio Code and make sure you have the **Java** extensions installed. 

2. Open the Main class and run the main method to play. 


 ## Usage

1. Select a Game Type: Choose from pre-defined game templates (simple or advanced) or start from scratch. <br>
 **OR** Select Your Saved Game: If you don't choose a pre-defined game type, you can also continue a saved game.
2. Customize Game Elements: Add and configure game tiles, cards, boards, and rules.
3. Preview and Test: Use the built-in games first to see how your own game will look.
4. Save and Reload: Save your progress in JSON format and reload it anytime to continue where you left off. Every game you saved is renamed followed by the name you gave and the phrase "_save" to recognise it more easily.
5. Export Your Game: Save your finished game to share with others.
6. Create Your Own Game: Leverage the Factory Design Pattern to create new classes for boards, tiles, or cards, giving you the flexibility to design completely new types of games. Design your own game's specifications using the **example.json**. <br>**Make sure you configure every tile considering the amount of tiles you defined to have on your dashboard in example.json.**

### JSON Syntax

In the Board Game Generator, JSON (JavaScript Object Notation) is used to define and save the game specifications. JSON is a lightweight data-interchange format that is easy to read and write for humans and easy to parse and generate for machines. It uses name/value pairs and arrays to represent data.

Here is a brief overview of the JSON structure used in the project:

JSON Elements:

1. game: Contains general game settings.
   - players: The number of players in the game.
   - board_size: The number of tiles on the game board.
   - board_type: The type of board (e.g., "endless" or "limited").
   - dice_number: The number of dice used in the game.
   - initial_player_points: The initial points each player starts with.
   - rounds: The number of rounds for the game.

2. tiles: An array of tile objects, each representing a tile on the game board.
   - index: The position of the tile on the board.
   - stat: The type of the tile (e.g., "start", "red", "card").
   - parameter: The effect triggered by the tile (e.g., "points", "tile").
   - value: The value associated with the tile effect (e.g., points gained or lost).

3. cards: An array of card objects, each representing a card in the game.
   - id: The unique identifier for the card.
   - message: The message displayed when the card is drawn.
   - parameter: The effect triggered by the card (e.g., "steal_points", "start").
   - value: The value associated with the card effect (e.g., points gained or lost).

4. rules: An array of rule objects, each defining a specific rule for the game.
   - rule: The text of the rule.


<table>
  <tr>
    <td>
    Game and tiles configuration
     <img src="https://github.com/helenzina/Game-Generator/blob/main/screenshots/json_1.png" title="json_1"/>
    </td>
    <td>
    Cards configuration
     <img src="https://github.com/helenzina/Game-Generator/blob/main/screenshots/json_2.png" title="json_2"/>
    </td>
    <td>
    Rules configuration
     <img src="https://github.com/helenzina/Game-Generator/blob/main/screenshots/json_3.png" title="json_3"/>
    </td>
</tr>
</table>

### Generalized Class Diagram
The class diagram illustrates the relationships between various classes in the project. 

<img src="https://github.com/helenzina/Game-Generator/blob/main/screenshots/class_diagram.png" title="class_diagram"/>

Here's a detailed explanation of the relationships and interactions:

1. Association Relationship:

   - Main and Game: There is an association relationship between the Main and Game classes. This means that the Main class creates or interacts with instances of the Game class, facilitating the main game flow.
   - Game with Players and Boards: The Game class is associated with Players and Boards. This implies that a Game object contains or manages multiple Player objects and a Board object.

2. Composition Relationship:

   - Board with Tiles, Cards, Dice, and Rules: The Board class has a composition relationship with Tiles, Cards, Dice, and Rules. This means that Board objects are composed of these elements, and these elements cannot exist independently of the Board. The Board manages and coordinates these elements to define the game structure.

3. Dependency Relationship:

   - Main, Game and Validate: There is a dependency relationship between the Main and Game classes with the Validate class. This indicates that the Main and Game classes relies on the Validate class to perform certain validation checks. The Validate class provides methods to ensure the integrity and correctness of game states and actions.



### Running 

Here are some examples of the game generator running (endless board):

<table>
  <tr>
    <td>
    Available game choices
     <img src="https://github.com/helenzina/Game-Generator/blob/main/screenshots/choices.png" title="choices"/>
    </td>
    <td>
    During gameplay
     <img src="https://github.com/helenzina/Game-Generator/blob/main/screenshots/play.png" title="play"/>
    </td>
    <td>
    Gameplay state
     <img src="https://github.com/helenzina/Game-Generator/blob/main/screenshots/state.png" title="state"/>
    </td>
    <td>
    Winner declaration
     <img src="https://github.com/helenzina/Game-Generator/blob/main/screenshots/winner.png" title="winner"/>
    </td>
</tr>
</table>

 
## Collaborators

<p>This project was developed for the "Programming Methodology" course at International Hellenic University. A special thanks to the following for their contributions and support:</p>
<table>
<tr>

<td align="center">
<a href="https://github.com/helenzina">
<img src="https://avatars.githubusercontent.com/u/128386591?v=4" width="100;" alt="Helen Zina"/><br>
<sub>
<b>Helen Zina (Me)</b>
</sub>
</a>
</td>

<td align="center">
<a href="https://github.com/alk-an">
<img src="https://avatars.githubusercontent.com/u/147655333?v=4" width="100px;" alt="Alkinoos Anastasiadis"/><br>
<sub>
<b>Alkinoos Anastasiadis</b>
</sub>
</a>
</td>

<td align="center">
<a href="https://github.com/LagiokapasDimitrios">
<img src="https://avatars.githubusercontent.com/u/147161663?v=4" width="100px;" alt="Dimitrios Lagiokapas"/><br>
<sub>
<b>Dimitrios Lagiokapas</b>
</sub>
</a>
</td>

<td align="center">
<a href="https://github.com/StylianiMakri">
<img src="https://avatars.githubusercontent.com/u/132708484?v=4" width="100px;" alt="Styliani Makri"/><br>
<sub>
<b>Styliani Makri</b>
</sub>
</a>
</td>

</tr>
</table>

 ## License

Distributed under the MIT License. See the LICENSE file for more information.

 ## Contact
 
If you have any questions or suggestions, feel free to reach out to us:
- Helen Zina - helenz1@windowslive.com
- Project Link: https://github.com/helenzina/Game-Generator

 ## Acknowledgments

The resources that helped us through this whole process are mentioned in the bibliography of our report.

For more information, read the english version of our report (**report en.pdf**).
