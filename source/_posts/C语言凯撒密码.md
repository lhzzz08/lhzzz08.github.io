---
title: C语言凯撒密码
date: 2024-11-22 15:42:37
tags:
---
```C
#include<stdio.h>
#include<string.h>
#include<ctype.h>
int main(){
    char str[81];
    fgets(str,sizeof(str),stdin);
    str[strcspn(str,"\n")]='\0';
    int offset=0;
    scanf("%d",&offset);
    offset=offset%26;
    for(int i=0;str[i]!='\0';i++){
        if(isalpha(str[i])){
            char base=islower(str[i])?'a':'A';
            str[i]=(str[i]-base+offset+26)%26+base;
        }
    }
    printf("%s\n",str);
    return 0;
}
```