//types date

let myString : string = "myString";
let myNumber : number = 33;
let myBoolean : boolean = false;

let array1 : number[] = [1, 2, 3];
let array2 : Array<number> = [1, 2, 3];

let tupla1 : [string, number, boolean]= ['Doaa',2,true];

let truplaArr : [number, string][];

truplaArr = [
    [1, 'qwe'],
    [2, 'qwe'],
    [3, 'qwe']
];

//inferencia de datos

let myVariable;

let myVariable1: string;

let myVariable2: boolean = true;

//unios

let myVariable3: string | number | null;
myVariable3 = 10;
myVariable3 = "";
myVariable3 = null;

enum Roles {
    User,
    Admin,
    SuperAdmin
}

console.log(Roles.User);

// Type assetion o cast

let channel : any = 'Dominicode';

let channelStr = <String>channel;

// const myCanvas1 = document.getElementById("main") as HTMLCanvasElement;

// const myCanvas2 = <HTMLCanvasElement>document.getElementById("main") ;


function greet(name : String){
    console.log(`My name is ${name}`);
}

function getNumber() : number {
    return Math.floor(Math.random() * 100);
}

greet("juan");

console.log(getNumber());

function printPosition(x : number | string = 10, y : number | string = 20){
    console.log(`Longitud and latitud : ${x}, ${y}`); 
}

printPosition(100,60);

interface Book{
    id: number;
    title: string;
    author: string;
    coAuthor?: string;
    isLoan?: (title: string)=>void;
}

const book:Book = {
    id: 100,
    title: "asd",
    author: ""
}

const books : Book[] = [];

function getBook(): Book {
    return {id: 1, title:"", author:"",};
}

const myBook = getBook();

function createBook(book:Book) : Book {
    return book;
}

const newBook: Book = {
    id: 1, title:"", author:"",
};

createBook(newBook);