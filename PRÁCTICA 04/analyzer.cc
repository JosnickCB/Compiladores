#include <iostream>
#include <cstring>
#include <vector>
#include <utility>
#include <set>
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
            <<" , tipo = "<<tipo/*<<'\n'*/;
        }

        int getIndice(){
            return indice;
        }

        char* getPalabra(){
            return palabra;
        }

        char getTipo(){
            return tipo;
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

Token reconoceAgrupador( char **ptr , int &index ){
    Token TokenAgrupador;
    TokenAgrupador.AddLetter(**ptr);
    TokenAgrupador.setIndice(index);
    TokenAgrupador.setTipo('A');
    return TokenAgrupador;
}

Token reconoceIgual( char **ptr , int &index ){
    Token TokenIgual;
    TokenIgual.AddLetter(**ptr);
    TokenIgual.setIndice(index);
    TokenIgual.setTipo('I');
    return TokenIgual;
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
                    //index++;
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
                    //index++;
                }
                index++;
                tokens.push_back( token );
                break;
            }
            
            case '-' : case '*' : case '/' : case '+' :
            {
                Token token = reconoceOperador( &linea , index );
                // Los operadores en esta ocasion solo se presentan de 
                // 1 en 1 , solo es necesario agregar un char 
                linea++;
                index++;
                tokens.push_back( token );
                break;
            }
            
            case '(' : case ')':
            {
                Token token = reconoceAgrupador( &linea , index );
                linea++;
                index++;
                tokens.push_back( token );
                break;
            }

            case '=':
            {
                Token token = reconoceIgual( &linea , index );
                linea++;
                index++;
                tokens.push_back( token );
                break;
            }

            case '\0': break;

            default:{ 
                linea++;
                //index++;
            } // Significa que encontró un espacio en blanco
        }
        if(*linea == '\0') break;
    }
    return tokens;
}

pair<char*,pair<int,int>> getEXPR( vector<Token>& , set<pair<char*,pair<int,int>>>& );

pair<char*,pair<int,int>> EXPR1( vector<Token> &tokens , set<pair<char*,pair<int,int>>>& content){

    /*//vector<int> aux;/*;
    cout<<"[--";
    for(auto i:tokens){
        i.toString();
    }
    cout<<"--]\n";
    for(auto i:aux){
        vector<Token> left = vector<Token>(tokens.begin(),tokens.begin()+i);
        vector<Token> right = vector<Token>(tokens.begin()+i+1,tokens.end());
        pair<char*,pair<int,int>> Left = getEXPR( left , content);
        pair<char*,pair<int,int>> Right = getEXPR( right , content);

    }*/
    //vector<int> comparative;
    //int first_operator;
    for(int i=0;i<tokens.size();i++){
        if(tokens[i].getTipo() == 'O'){
            //first_operator = i;
            //operator_finded = true;
            //cout<<tokens[i].getIndice()<<endl;
            //cout<<"TAM: "<<comparative.size()<<endl;
            //comparative.push_back( tokens[i].getIndice() );
            vector<Token> left = vector<Token>(tokens.begin(),tokens.begin()+i);
            /*cout<<'[';
            for(auto x:left)
                cout<<x.getPalabra();
            cout<<"]\n";
            cout<<'[';*/
            vector<Token> right = vector<Token>(tokens.begin()+i+1,tokens.end());
            /*for(auto x:right)
                cout<<x.getPalabra();
            cout<<"]\n";*/
            pair<char*,pair<int,int>> Left = getEXPR( left , content);
            /*if(Left){

            }*/
            pair<char*,pair<int,int>> Right = getEXPR( right , content);
            if(Right.second.second != -1 && Left.second.second != -1){
                cout<<"OP "<<'<'<<i<<','<<i<<'>'<<endl;
                char* type = (char*)"EXPR1 ";
                return make_pair( type , make_pair(Left.second.second,Right.second.first) );
            }
        }
    }
    char* type = (char*)"ERROR ";
    return make_pair( type , make_pair(-1,-1) );

    
    /*if(!operator_finded){
        //cout<< "Error de EXPR1" <<endl;
        char* type = (char*)"ERROR ";
        return make_pair( type , make_pair(-1,-1) );
    /*}*/
    

    
}

pair<char*,pair<int,int>> EXPR2( vector<Token> &tokens , set<pair<char*,pair<int,int>>>& content ){
    /*if(tokens.size() < 3){
        char* type = (char*)"ERROR ";
        return make_pair( type , make_pair(-1,-1) );
    }*/

    //cout<<"ENTRO EXPR2"<<endl;
    /*int parenthesis_counter = 0;
    bool parenthesis_finded = false;
    for(int i=0;i<tokens.size();i++){
        if(*(tokens[i].getPalabra())=='(')
            parenthesis_counter++;
            parenthesis_finded = true;
        if(*(tokens[i].getPalabra())==')' && !parenthesis_finded){
            char* type = (char*)"ERROR ";
            return make_pair( type , make_pair(-1,-1) );
        }else{
            parenthesis_counter--;
        }
    }
    if(parenthesis_counter != 0 && !parenthesis_finded){
        //cout<< "Error de EXPR2" <<endl;
        char* type = (char*)"ERROR ";
        return make_pair( type , make_pair(-1,-1) );
    }*/

    /*for(auto x : tokens)
        x.toString();
        cout<<endl;*/
    if(*(tokens[0].getPalabra())=='(' && *(tokens[tokens.size()-1].getPalabra())==')'){
        vector<Token> cutTokens = vector<Token>(tokens.begin()+1,tokens.end()-1);
        /*cout<<"CUTOKENS SIZE : "<<cutTokens.size()<<endl;
        cout<<"EXPR2 creo Right y Left"<<endl;*/
        pair<char*,pair<int,int>> CutTokens = getEXPR( cutTokens , content );
        if(CutTokens.second.first == -1){
            char* type = (char*)"ERROR ";
            return make_pair( type , make_pair(-1,-1) );
        }
        char* type = (char*)"EXPR2 ";
        //content.insert(make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) ) );
        return make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) );
    }else{
        char* type = (char*)"ERROR ";
        return make_pair( type , make_pair(-1,-1) );
    }
    
    /*char* type = (char*)"EXPR2 ";
    //cout<<type<<'<'<<tokens[0].getIndice()<<','<<tokens[tokens.size()-1].getIndice()<<'>'<<endl;
    return make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) );*/
}


pair<char*,pair<int,int>> EXPR3( vector<Token> &tokens , set<pair<char*,pair<int,int>>>& content){
    //cout<<"ENTRO EXPR3"<<endl;
    if(tokens.size() == 1 && ( tokens[0].getTipo() == 'E' || tokens[0].getTipo() == 'V' )){
        if(tokens[0].getTipo() == 'E'){
            char* type = (char*)"NUM ";
            //cout<<type<<'<'<<tokens[0].getIndice()<<','<<tokens[tokens.size()-1].getIndice()<<'>'<<endl;
            //content.insert(make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) ) );
            return make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) );
        }else{
            char* type = (char*)"VAR ";
            //cout<<type<<'<'<<tokens[0].getIndice()<<','<<tokens[tokens.size()-1].getIndice()<<'>'<<endl;
            //content.insert(make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) ) );
            return make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) );
        }
        
    }else{
        //cout<< "Error de EXPR3" <<endl;
        char* type = (char*)"ERROR ";
        return make_pair( type , make_pair(-1,-1) );
    }
    
}


pair<char*,pair<int,int>> getEXPR( vector<Token> &tokens , set<pair<char*,pair<int,int>>>& content ){
    pair<char*,pair<int,int>> EXP1 = EXPR1(tokens , content);
    pair<char*,pair<int,int>> EXP2 = EXPR2(tokens , content);
    pair<char*,pair<int,int>> EXP3 = EXPR3(tokens , content);
    if(EXP1.second.second != -1){
        cout<<EXP1.first<<'<'<<EXP1.second.first<<','<<EXP1.second.second<<'>'<<endl;
        return EXP1;
    }
    if(EXP2.second.second != -1){
        cout<<EXP2.first<<'<'<<EXP2.second.first<<','<<EXP2.second.second<<'>'<<endl;
        return EXP2;
    }
    if(EXP3.second.second != -1){
        cout<<EXP3.first<<'<'<<EXP3.second.first<<','<<EXP3.second.second<<'>'<<endl;
        return EXP3;
    }
    char* type = (char*)"ERROR ";
    return make_pair( type , make_pair(-1,-1) );
}

pair<char*,pair<int,int>> getEQUL( vector<Token> &tokens , set<pair<char*,pair<int,int>>>& content ){
    bool only_one_equal = false;
    int index_equal;
    for(int i=0;i<tokens.size();i++){
        if(*(tokens[i].getPalabra())=='='){
            if(only_one_equal){
                //cout<< "Error de igualdad" <<endl;
                char* type = (char*)"ERROR ";
                return make_pair( type , make_pair(-1,-1) );
            }
            index_equal = i;
            only_one_equal = true;
        }
    }

    vector<Token> left = vector<Token>(tokens.begin(),tokens.begin()+index_equal);
    vector<Token> right = vector<Token>(tokens.begin()+index_equal+1,tokens.end());
    pair<char*,pair<int,int>> Left = EXPR3( left , content );
    pair<char*,pair<int,int>> Right = getEXPR( right , content);
    if(Left.second.first != -1 && Right.second.first != -1){
        char* type = (char*)"IGUALDAD ";
        //char* type = new char[9];
        //content.insert(make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) ) );
        cout<<Left.first<<'<'<<Left.second.first<<','<<Left.second.second<<'>'<<endl;
        cout<<"IGUAL "<<'<'<<index_equal<<','<<index_equal<<'>'<<endl;
        cout<<Right.first<<'<'<<Right.second.first<<','<<Right.second.second<<'>'<<endl;
        return make_pair( type , make_pair(tokens[0].getIndice(),tokens[tokens.size()-1].getIndice()) );
    }
    char* type = (char*)"ERROR ";
    return make_pair( type , make_pair(-1,-1) );
    
}

pair<char*,pair<int,int>> getCMD( vector<Token> &tokens , set<pair<char*,pair<int,int>>>& content){
    pair<char*,pair<int,int>> EQUL = getEQUL( tokens , content );
    pair<char*,pair<int,int>> EXPR = getEXPR( tokens , content );

    if(EQUL.second.first != -1)
        cout<<EQUL.first<<'<'<<EQUL.second.first<<','<<EQUL.second.second<<'>'<<endl;
        return EQUL;

    if(EXPR.second.first != -1)
        cout<<EXPR.first<<'<'<<EXPR.second.first<<','<<EXPR.second.second<<'>'<<endl;
        return EXPR;
    
    char* type = (char*)"ERROR ";
    return make_pair(type,make_pair(-1,-1));
}

int main(){
    char linea[ 100 ] = "variable3 = ( (1+2) * (3+4) ) * ( variable1 + variable2 )";
    vector<Token> tokens = analizadorLexico( linea );
    //for( auto token : tokens )
    //    token.toString();
    set<pair<char*,pair<int,int>>> content ;
    pair<char*,pair<int,int>> Rpta = getCMD( tokens , content );
    cout<<Rpta.first<<'<'<<Rpta.second.first<<','<<Rpta.second.second<<'>'<<endl;
    for(auto i : content){
        cout<<i.first<<'<'<<i.second.second<<','<<i.second.second<<'>'<<endl;
    }
}