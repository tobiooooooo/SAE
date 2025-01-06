fetch('indicator.php')
    .then(response => response.json())
    .then(data => {
        console.log('Réponse de l\'API :', data); // Ajouter un log pour vérifier la réponse de l'API

        if (data.success) {
            // Afficher les statistiques globales
            document.getElementById('total-users').textContent = `Total utilisateurs : ${data.data.total_users}`;
            document.getElementById('average-age').textContent = `Âge moyen : ${data.data.average_age}`;

            // Données pour les graphiques
            const regions = Object.entries(data.data.regions || {});
            const satisfaction = Object.entries(data.data.satisfaction || {});
            const supportTypes = Object.entries(data.data.support_types || {});
            const environments = Object.entries(data.data.environments || {});
            const socialActivities = Object.entries(data.data.social_activities || {});
            const healthIssues = Object.entries(data.data.health_issues || {});

            console.log('Données pour les graphiques :', { regions, satisfaction, supportTypes, environments, socialActivities, healthIssues }); // Ajouter un log pour vérifier les données

            const createBarChart = (selector, data, color, title, xLabel, yLabel) => {
                const width = 600;
                const height = 400;
                const margin = { top: 60, right: 40, bottom: 80, left: 80 };

                const svg = d3.select(selector)
                    .append('svg')
                    .attr('width', width + margin.left + margin.right)
                    .attr('height', height + margin.top + margin.bottom)
                    .append('g')
                    .attr('transform', `translate(${margin.left},${margin.top})`);

                const xScale = d3.scaleBand()
                    .domain(data.map(d => d[0]))
                    .range([0, width])
                    .padding(0.3);

                const yScale = d3.scaleLinear()
                    .domain([0, d3.max(data, d => d[1])])
                    .range([height, 0]);

                const colorScale = d3.scaleOrdinal(d3.schemeCategory10);

                // Barres
                svg.selectAll('.bar')
                    .data(data)
                    .enter()
                    .append('rect')
                    .attr('class', 'bar')
                    .attr('x', d => xScale(d[0]))
                    .attr('y', height)
                    .attr('width', xScale.bandwidth())
                    .attr('height', 0)
                    .attr('fill', d => colorScale(d[0]))
                    .transition()
                    .duration(1000)
                    .attr('y', d => yScale(d[1]))
                    .attr('height', d => height - yScale(d[1]));

                svg.selectAll('.label')
                    .data(data)
                    .enter()
                    .append('text')
                    .attr('x', d => xScale(d[0]) + xScale.bandwidth() / 2)
                    .attr('y', d => yScale(d[1]) - 5)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '12px')
                    .style('font-weight', 'bold')
                    .text(d => d[1]);

                // Axe X
                svg.append('g')
                    .attr('transform', `translate(0,${height})`)
                    .call(d3.axisBottom(xScale))
                    .selectAll('text')
                    .attr('transform', 'rotate(-45)')
                    .style('text-anchor', 'end')
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Axe Y
                svg.append('g')
                    .call(d3.axisLeft(yScale))
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Étiquettes des axes
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', height + margin.bottom - 20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(xLabel);

                svg.append('text')
                    .attr('transform', 'rotate(-90)')
                    .attr('x', -height / 2)
                    .attr('y', -margin.left + 30)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(yLabel);

                // Titre
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', -20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '18px')
                    .style('font-weight', 'bold')
                    .text(title);
            };

            const createLineChart = (selector, data, color, title, xLabel, yLabel) => {
                const width = 600;
                const height = 400;
                const margin = { top: 60, right: 40, bottom: 80, left: 80 };

                const svg = d3.select(selector)
                    .append('svg')
                    .attr('width', width + margin.left + margin.right)
                    .attr('height', height + margin.top + margin.bottom)
                    .append('g')
                    .attr('transform', `translate(${margin.left},${margin.top})`);

                const xScale = d3.scaleBand()
                    .domain(data.map(d => d[0]))
                    .range([0, width])
                    .padding(0.3);

                const yScale = d3.scaleLinear()
                    .domain([0, d3.max(data, d => d[1])])
                    .range([height, 0]);

                const line = d3.line()
                    .x(d => xScale(d[0]) + xScale.bandwidth() / 2)
                    .y(d => yScale(d[1]));

                // Ligne
                svg.append('path')
                    .datum(data)
                    .attr('fill', 'none')
                    .attr('stroke', color)
                    .attr('stroke-width', 2)
                    .attr('d', line);

                // Points
                svg.selectAll('.dot')
                    .data(data)
                    .enter()
                    .append('circle')
                    .attr('cx', d => xScale(d[0]) + xScale.bandwidth() / 2)
                    .attr('cy', d => yScale(d[1]))
                    .attr('r', 5)
                    .attr('fill', color);

                // Axe X
                svg.append('g')
                    .attr('transform', `translate(0,${height})`)
                    .call(d3.axisBottom(xScale))
                    .selectAll('text')
                    .attr('transform', 'rotate(-45)')
                    .style('text-anchor', 'end')
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Axe Y
                svg.append('g')
                    .call(d3.axisLeft(yScale))
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Étiquettes des axes
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', height + margin.bottom - 20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(xLabel);

                svg.append('text')
                    .attr('transform', 'rotate(-90)')
                    .attr('x', -height / 2)
                    .attr('y', -margin.left + 30)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(yLabel);

                // Titre
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', -20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '18px')
                    .style('font-weight', 'bold')
                    .text(title);
            };

            const createAreaChart = (selector, data, color, title, xLabel, yLabel) => {
                const width = 600;
                const height = 400;
                const margin = { top: 60, right: 40, bottom: 80, left: 80 };

                const svg = d3.select(selector)
                    .append('svg')
                    .attr('width', width + margin.left + margin.right)
                    .attr('height', height + margin.top + margin.bottom)
                    .append('g')
                    .attr('transform', `translate(${margin.left},${margin.top})`);

                const xScale = d3.scaleBand()
                    .domain(data.map(d => d[0]))
                    .range([0, width])
                    .padding(0.3);

                const yScale = d3.scaleLinear()
                    .domain([0, d3.max(data, d => d[1])])
                    .range([height, 0]);

                const area = d3.area()
                    .x(d => xScale(d[0]) + xScale.bandwidth() / 2)
                    .y0(height)
                    .y1(d => yScale(d[1]));

                // Aire
                svg.append('path')
                    .datum(data)
                    .attr('fill', color)
                    .attr('d', area);

                // Axe X
                svg.append('g')
                    .attr('transform', `translate(0,${height})`)
                    .call(d3.axisBottom(xScale))
                    .selectAll('text')
                    .attr('transform', 'rotate(-45)')
                    .style('text-anchor', 'end')
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Axe Y
                svg.append('g')
                    .call(d3.axisLeft(yScale))
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Étiquettes des axes
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', height + margin.bottom - 20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(xLabel);

                svg.append('text')
                    .attr('transform', 'rotate(-90)')
                    .attr('x', -height / 2)
                    .attr('y', -margin.left + 30)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(yLabel);

                // Titre
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', -20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '18px')
                    .style('font-weight', 'bold')
                    .text(title);
            };

            const createScatterPlot = (selector, data, color, title, xLabel, yLabel) => {
                const width = 600;
                const height = 400;
                const margin = { top: 60, right: 40, bottom: 80, left: 80 };

                const svg = d3.select(selector)
                    .append('svg')
                    .attr('width', width + margin.left + margin.right)
                    .attr('height', height + margin.top + margin.bottom)
                    .append('g')
                    .attr('transform', `translate(${margin.left},${margin.top})`);

                const xScale = d3.scaleBand()
                    .domain(data.map(d => d[0]))
                    .range([0, width])
                    .padding(0.3);

                const yScale = d3.scaleLinear()
                    .domain([0, d3.max(data, d => d[1])])
                    .range([height, 0]);

                // Points
                svg.selectAll('.dot')
                    .data(data)
                    .enter()
                    .append('circle')
                    .attr('cx', d => xScale(d[0]) + xScale.bandwidth() / 2)
                    .attr('cy', d => yScale(d[1]))
                    .attr('r', 5)
                    .attr('fill', color);

                // Axe X
                svg.append('g')
                    .attr('transform', `translate(0,${height})`)
                    .call(d3.axisBottom(xScale))
                    .selectAll('text')
                    .attr('transform', 'rotate(-45)')
                    .style('text-anchor', 'end')
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Axe Y
                svg.append('g')
                    .call(d3.axisLeft(yScale))
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Étiquettes des axes
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', height + margin.bottom - 20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(xLabel);

                svg.append('text')
                    .attr('transform', 'rotate(-90)')
                    .attr('x', -height / 2)
                    .attr('y', -margin.left + 30)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(yLabel);

                // Titre
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', -20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '18px')
                    .style('font-weight', 'bold')
                    .text(title);
            };

            const createStackedBarChart = (selector, data, color, title, xLabel, yLabel) => {
                const width = 600;
                const height = 400;
                const margin = { top: 60, right: 40, bottom: 80, left: 80 };

                const svg = d3.select(selector)
                    .append('svg')
                    .attr('width', width + margin.left + margin.right)
                    .attr('height', height + margin.top + margin.bottom)
                    .append('g')
                    .attr('transform', `translate(${margin.left},${margin.top})`);

                const xScale = d3.scaleBand()
                    .domain(data.map(d => d[0]))
                    .range([0, width])
                    .padding(0.3);

                const yScale = d3.scaleLinear()
                    .domain([0, d3.max(data, d => d[1])])
                    .range([height, 0]);

                const colorScale = d3.scaleOrdinal(d3.schemeCategory10);

                const stack = d3.stack()
                    .keys(data.map(d => d[0]))
                    .value((d, key) => d[key]);

                const layers = stack(data);

                // Barres empilées
                svg.selectAll('.layer')
                    .data(layers)
                    .enter()
                    .append('g')
                    .attr('class', 'layer')
                    .attr('fill', (d, i) => colorScale(i))
                    .selectAll('rect')
                    .data(d => d)
                    .enter()
                    .append('rect')
                    .attr('x', (d, i) => xScale(i))
                    .attr('y', d => yScale(d[1]))
                    .attr('height', d => yScale(d[0]) - yScale(d[1]))
                    .attr('width', xScale.bandwidth());

                // Axe X
                svg.append('g')
                    .attr('transform', `translate(0,${height})`)
                    .call(d3.axisBottom(xScale))
                    .selectAll('text')
                    .attr('transform', 'rotate(-45)')
                    .style('text-anchor', 'end')
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Axe Y
                svg.append('g')
                    .call(d3.axisLeft(yScale))
                    .style('font-size', '12px')
                    .style('font-weight', 'bold');

                // Étiquettes des axes
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', height + margin.bottom - 20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(xLabel);

                svg.append('text')
                    .attr('transform', 'rotate(-90)')
                    .attr('x', -height / 2)
                    .attr('y', -margin.left + 30)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '14px')
                    .style('font-weight', 'bold')
                    .text(yLabel);

                // Titre
                svg.append('text')
                    .attr('x', width / 2)
                    .attr('y', -20)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '18px')
                    .style('font-weight', 'bold')
                    .text(title);
            };

            const createPieChart = (selector, data, colors, title) => {
                const width = 500;
                const height = 500;
                const radius = Math.min(width, height) / 2;

                const svg = d3.select(selector)
                    .append('svg')
                    .attr('width', width)
                    .attr('height', height)
                    .append('g')
                    .attr('transform', `translate(${width / 2},${height / 2})`);

                const color = d3.scaleOrdinal(colors);

                const pie = d3.pie().value(d => d[1]);

                const arc = d3.arc()
                    .innerRadius(0)
                    .outerRadius(radius);

                const dataReady = pie(data);

                // Dessiner les segments
                svg.selectAll('path')
                    .data(dataReady)
                    .join('path')
                    .attr('d', arc)
                    .attr('fill', d => color(d.data[0]))
                    .attr('stroke', 'white')
                    .style('stroke-width', '2px');

                // Ajouter des étiquettes (textes)
                svg.selectAll('text')
                    .data(dataReady)
                    .join('text')
                    .attr('transform', d => `translate(${arc.centroid(d)})`)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '12px')
                    .style('font-weight', 'bold')
                    .text(d => `${d.data[0]}: ${d.data[1]}`);

                // Ajouter un titre au graphique
                svg.append('text')
                    .attr('x', 0)
                    .attr('y', -height / 2 + 30)
                    .attr('text-anchor', 'middle')
                    .style('font-size', '20px')
                    .style('font-weight', 'bold')
                    .text(title);
            };

            // Créer les graphiques
            createBarChart('#chart-region', regions, 'steelblue', 'Répartition par Région', 'Régions', 'Nombre d\'utilisateurs');
            createLineChart('#chart-satisfaction', satisfaction, 'orange', 'Satisfaction Globale', 'Niveau de Satisfaction', 'Nombre d\'utilisateurs');
            createAreaChart('#chart-support', supportTypes, 'green', 'Répartition des Besoins de Soutien', 'Types de Soutien', 'Nombre');
            createBarChart('#chart-environment', environments, 'purple', 'Répartition par Environnement', 'Environnements', 'Nombre d\'utilisateurs');
            createStackedBarChart('#chart-social-activities', socialActivities, 'teal', 'Activités Sociales', 'Activités Sociales', 'Nombre d\'utilisateurs');
            createScatterPlot('#chart-health-issues', healthIssues, 'red', 'Problèmes de Santé Majeurs', 'Problèmes de Santé', 'Nombre d\'utilisateurs');

            // Camembert pour l'environnement
            const environmentColors = ['#FF9999', '#66B3FF', '#99FF99', '#FFCC99'];
            createPieChart('#pie-environment', environments, environmentColors, 'Répartition par Environnement');

            // Camembert pour les activités sociales
            const socialColors = ['#FFB6C1', '#8A2BE2', '#7FFF00', '#FFD700'];
            createPieChart('#pie-social', socialActivities, socialColors, 'Activités Sociales');

        } else {
            alert(data.message || 'Erreur inconnue.');
        }
    })
    .catch(error => {
        console.error('Erreur lors du chargement des données :', error);
        alert("Une erreur s'est produite lors du chargement des statistiques.");
    });
