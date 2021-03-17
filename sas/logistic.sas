%GLOBAL counter;
%let counter=0;

/*単変量ロジスティック回帰のマクロを作成してみたが、パフォーマンス的にどうなんだろうか */
%macro dologistic(dataset, outcome, explanatory, iscategorical);
    
    %let counter=%eval(&counter+1);
    /* データセットのobs数 */
    ods output nobs = nobs&counter;
    
    /* REG, GLMが生成するオブジェクト */
    ods output parameterestimates = para&counter;
    
    proc logistic data=&dataset plots=all;
        class &outcome;
        %if &iscategorical = TRUE %then %do;
            class &explanatory;
        %end;
        model &outcome(event='1') = &explanatory;
        oddsratio &explanatory;
    run;
    
    data nobs&counter(keep=n outid nobsread); 
        set nobs&counter;
        where label='使用されたオブザベーション';
        counter=&counter;
    run;

    data para&counter; 
        set para&counter; 
        where variable^='Intercept';
        counter=&counter;
        lcl=exp(estimate-probit(0.975)*stderr);
        ucl=exp(estimate+probit(0.975)*stderr);
    run;
   
%mend dologistic;