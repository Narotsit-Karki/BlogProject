#include<stdio.h>
#include<conio.h>
int totient(int n)
{ 
	int result = n;
	int i=0;
	for(i=2; i*i<=n; i++){
		// this for loop is used for calculating modular division of the data.
		if (n % i == 0){
			result -= result/i;
			while(n % i == 0){
				n /= i;
			}
		}
	}

	if (n != 1){
		result -= result/n;
		}
		return result;
	}
	
int main(void) {
	int number, solution;
		
	printf("\n Enter number whose totient function value is to be calculated:");
	scanf("%d", &number);

	value = totient(number);
	printf("totient of %d is %d",number,value);
	return 0;
}