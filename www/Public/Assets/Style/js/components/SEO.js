document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('content-form');
    const contentInput = document.getElementById('content-input');
    const seoScoreElement = document.getElementById('seo-score');
    const seoSuggestionsElement = document.getElementById('seo-suggestions');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const content = contentInput.value;
        const targetKeywords = ['mot-clé1', 'mot-clé2', 'mot-clé3'];

        const seoScore = calculateSEO(content, targetKeywords);
        const seoSuggestions = getSEOSuggestions(seoScore);

        seoScoreElement.textContent = seoScore.toFixed(2);
        seoSuggestionsElement.innerHTML = '';
        seoSuggestions.forEach(suggestion => {
            const listItem = document.createElement('li');
            listItem.textContent = suggestion;
            seoSuggestionsElement.appendChild(listItem);
        });
    });

    function calculateSEO(content, targetKeywords) {
        return 0.5;
    }

    function getSEOSuggestions(seoScore) {
        const suggestions = [];
        if (seoScore < 0.5) {
            suggestions.push('Améliorer la densité de mots-clés.');
        }
        return suggestions;
    }
});