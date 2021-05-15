#include <iostream>
#include <cstring>
#include <vector>
using namespace std;

bool isNumber(char t){
    return (t == '0' || t == '1' || t == '2' || t == '3' || 
            t == '4' || t == '5' || t == '6' || t == '7' ||
            t == '8' || t == '9' );
}

bool isLetter(char t){
    return (t == 'a' || t == 'b' || t == 'c' || t == 'd' || 
            t == 'e' || t == 'f' || t == 'g' || t == 'h' || 
            t == 'i' || t == 'j' || t == 'k' || t == 'l' || 
            t == 'm' || t == 'n' || t == 'o' || t == 'p' || 
            t == 'q' || t == 'r' || t == 's' || t == 't' ||
            t == 'u' || t == 'v' || t == 'w' || t == 'x' || 
            t == 'y' || t == 'z' || t == 'A' || t == 'B' || 
            t == 'C' || t == 'D' || t == 'E' || t == 'F' || 
            t == 'G' || t == 'H' || t == 'I' || t == 'J' || 
            t == 'K' || t == 'L' || t == 'M' || t == 'N' ||
            t == 'O' || t == 'P' || t == 'Q' || t == 'R' ||
            t == 'S' || t == 'T' || t == 'U' || t == 'V' || 
            t == 'W' || t == 'X' || t == 'Y' || t == 'Z' );
}

class Token {
    char *palabra; //almacena una copia de la palabra
    int indice;
    char tipo; //E (entero), V (variable), O (operador)
    public:
        // Constructor inicializa en \0 para evitar elementos   +
        // basura al momento de guardar contenido de palabra    |
        Token(){//                                              |
            palabra = new char[1];//                            |
            palabra[0] = '\0';//                                |
        }//                                                     +

        // AddLetter crea memoria dinámica para simular un      +
        // push_back en el puntero a palabra y asi ir creando   |
        // el contenido de la palabra                           |
        void AddLetter(char& letter){//                         |
            char* old = this->palabra;//                        |
            int len = strlen(this->palabra);//                  |
            this->palabra = new char[len+2];//                  |
            strcpy(palabra,old);//                              |
            //if(old!= NULL) delete old;                        |
            palabra[len] = letter;//                            |
            palabra[len+1] = '\0';//                            |
        }//                                                     +
        
        void setIndice(int index){
            this->indice = index;
        }
        
        void setTipo(char t){
            this->tipo = t;
        }
        
        void toString(){
            cout<<"Token["<<palabra<<"]: pos = "<<indice
            <<" , tipo = "<<tipo<<'\n';
        }
};

Token reconoceNumero( char **ptr , int &index ){
    Token TokenNumero;
    TokenNumero.AddLetter(**ptr);
    TokenNumero.setIndice(index);
    TokenNumero.setTipo('E');
    return TokenNumero;
}

Token reconoceVariable( char **ptr , int &index ){
    Token TokenVariable;
    TokenVariable.AddLetter(**ptr);
    TokenVariable.setIndice(index);
    TokenVariable.setTipo('V');
    return TokenVariable;
}

Token reconoceOperador( char **ptr , int &index ){
    Token TokenOperador;
    TokenOperador.AddLetter(**ptr);
    TokenOperador.setIndice(index);
    TokenOperador.setTipo('O');
    return TokenOperador;
}

vector<Token> analizadorLexico( char *linea ) {
    // index declarado como global en el scope de la función para 
    // poder usarlo en todos los casos del switch
    int index = 0;
    vector<Token> tokens;
    while(true) {
        switch( *linea ) {
            case '0' : case '1' : case '2' : case '3' : case '4' :
            case '5' : case '6' : case '7' : case '8' : case '9' :
            {
                Token token = reconoceNumero( &linea , index );
                // linea++ para verificar si existe un número
                // colindante
                linea++;
                // El bucle busca números a la derecha hasta
                // encontrar un espacio y verificando que el 
                // puntero contenga solo números
                while(isNumber( *linea )){
                    token.AddLetter( *linea );
                    linea++;
                    index++;
                }
                index++;
                tokens.push_back( token );
                break;
            }
            
            case 'a' : case 'b' : case 'c' : case 'd' : case 'e' : 
            case 'f' : case 'g' : case 'h' : case 'i' : case 'j' : 
            case 'k' : case 'l' : case 'm' : case 'n' : case 'o' : 
            case 'p' : case 'q' : case 'r' : case 's' : case 't' :
            case 'u' : case 'v' : case 'w' : case 'x' : case 'y' : 
            case 'z' : case 'A' : case 'B' : case 'C' : case 'D' : 
            case 'E' : case 'F' : case 'G' : case 'H' : case 'I' : 
            case 'J' : case 'K' : case 'L' : case 'M' : case 'N' : 
            case 'O' : case 'P' : case 'Q' : case 'R' : case 'S' : 
            case 'T' : case 'U' : case 'V' : case 'W' : case 'X' : 
            case 'Y' : case 'Z' :
            {
                Token token = reconoceVariable( &linea , index);
                // linea++ para verificar si existe algún carácter 
                // colindante al lado derecho
                linea++;
                // El bucle busca caractéres o números hasta que
                // encuentre un espacio , creando asi el token de
                // la variable
                while(isNumber( *linea ) || isLetter( *linea )){
                    token.AddLetter( *linea );
                    linea++;
                    index++;
                }
                index++;
                tokens.push_back( token );
                break;
            }
            
            case '(' : case ')' : case '[' : case ']' : case '{' : 
            case '}' : case '=' : case '/' : case '+' :
            {
            Token token = reconoceOperador( &linea , index);
            // Los operadores en esta ocasion solo se presentan de 
            // 1 en 1 , solo es necesario agregar un char 
            linea++;
            index++;
            tokens.push_back( token );
            break;
            }
            case '\0': break;
            
            default:{ 
                linea++;
                index++;
            } // Significa que encontró un espacio en blanco
        }
        if(*linea == '\0') break;
    }
    return tokens;
}


int main(){
    char linea[ 50 ] = "variable100 = 100 + 100 )";
    vector<Token> tokens = analizadorLexico( linea );
    for( auto token : tokens )
        token.toString();
}
