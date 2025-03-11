import * as d3 from "d3";

document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById("toggleGenera");

    function loadChart(includeGenera) {
        const url = includeGenera ? "/taxonomy-json-with-genera" : "/taxonomy-json-without-genera";
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Use to clear old chart before replace
                document.getElementById("chart").innerHTML = "";
                const chart = createChart(data);
                document.getElementById("chart").appendChild(chart);
            });
    }

    checkbox.addEventListener("change", function () {
        loadChart(this.checked);
    });

    loadChart(false); 
});

function createChart(data) {
    const width = 1200;
    const root = d3.hierarchy(data);
    const dx = 14;
    const dy = width / (root.height + 1);
    const tree = d3.cluster().nodeSize([dx, dy]);
    root.sort((a, b) => d3.ascending(a.data.name, b.data.name));
    tree(root);

    let x0 = Infinity, x1 = -x0;
    root.each(d => { x0 = Math.min(x0, d.x); x1 = Math.max(x1, d.x); });

    const height = x1 - x0 + dx * 2;

    const svg = d3.create("svg")
        .attr("width", width)
        .attr("height", height)
        .attr("viewBox", [-dy / 3, x0 - dx, width, height])
        .attr("style", "max-width: 100%; height: auto; font: 0.8em sans-serif;");

    // Tooltip setup
    const tooltip = d3.select("body")
        .append("div")
        .attr("id", "tooltip")
        .attr("class", "absolute hidden bg-white border border-gray-300 p-2 shadow-md rounded-md")
        .style("position", "absolute")
        .style("z-index", "10")
        .style("display", "none");

    // Draw links
    svg.append("g")
        .attr("fill", "none")
        .attr("stroke", "#555")
        .attr("stroke-opacity", 0.8)
        .attr("stroke-width", 1.5)
        .selectAll()
        .data(root.links())
        .join("path")
        .attr("d", d3.linkHorizontal()
            .x(d => d.y)
            .y(d => d.x));

    // Draw nodes
    const node = svg.append("g")
        .attr("stroke-linejoin", "round")
        .attr("stroke-width", 3)
        .selectAll()
        .data(root.descendants())
        .join("g")
        .attr("transform", d => `translate(${d.y},${d.x})`);

    node.append("circle")
        .attr("fill", d => d.children ? "#555" : "#999")
        .attr("r", 4);

    node.append("text")
        .attr("dy", "0.31em")
        .attr("x", d => d.children ? -6 : 6)
        .attr("text-anchor", d => d.children ? "end" : "start")
        .text(d => d.data.name)
        .attr("stroke", "white")
        .attr("paint-order", "stroke")
        .style("cursor", "pointer");

    // Add tooltip event handlers
    node.on("mouseover", (event, d) => {
        // Allow families common name
        if (!d.data.image && d.data.details) 
        { tooltip.style("display", "block")
            .html(`
                <p>${d.data.details}</p>
            `) 
            .style("box-shadow", "0 2px 10px rgba(0,0,0,0.2)");}
        // Allow species thumbnail and scientific name
        else if(d.data.image){
        tooltip.style("display", "block")
            .html(`
                <img src="${d.data.image}" class="w-64 h-64 object-cover rounded-md">
                <p class="text-center">${d.data.details}</p>
            `) 
            .style("box-shadow", "0 2px 10px rgba(0,0,0,0.2)");
        }
        // Dont show anything (/Orders/Genera)
        else{
            return
        }
    })
    .on("mousemove", (event) => {
        tooltip.style("left", `${event.pageX + 15}px`)
            .style("top", `${event.pageY + 15}px`);
    })
    .on("mouseleave", () => {
        tooltip.style("display", "none");
    });

    return svg.node();
}
