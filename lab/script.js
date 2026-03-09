function square(n) {
    return (n * n)
}
let a = 4;

console.log(square(a))

b = 6;

a = a + b;
b = a - b;
a = a - b;
console.log("a:", a, "b:", b)

let c = [464, 243, 1, 6878]
let d = 0;
for (i = 0; i < 4; i++) {

    if (c[i] > d) {
        d = c[i];
    }

}
console.log(`The largest numeber is: ${d}`)
