const ratings = {
    udang: {
        totalRating: 0,
        count: 0,
    },

    kakap: {
        totalRating: 0,
        count: 0,
    },

    tuna: {
        totalRating: 0,
        count: 0,
    },

    cumi: {
        totalRating: 0,
        count: 0,
    },
};


function submitRating(product) {
    const ratingSelect = document.getElementById(`rating-${product}`);

    if (!ratingSelect) {
        return;
    }

    const rating = parseInt(ratingSelect.value);

    if (!isNaN(rating)) {
        ratings[product].totalRating += rating;
        ratings[product].count += 1;

        const avgRating = (
            ratings[product].totalRating /
            ratings[product].count
        ).toFixed(2);

        const result = document.getElementById(
            `${product}-rating-result`
        );

        if (result) {
            result.innerHTML = `
                Total rating: ${ratings[product].totalRating},
                Jumlah pemberi rating: ${ratings[product].count},
                Rata-rata rating: ${avgRating}
            `;
        }
    }
}