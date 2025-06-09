

let categoryColors = {
    "学习": "rgba(75, 192, 192, 0.8)",
    "工作": "rgba(255, 99, 132, 0.8)",
    "休闲": "rgba(255, 206, 86, 0.8)",
    "运动": "rgba(54, 162, 235, 0.8)"
};

let chart; // 声明 chart 变量，但只在 DOMContentLoaded 内部赋值
let isChartInitialized = false;
// 核心修正：确保在 DOM 内容完全加载后才执行 Chart.js 的初始化
document.addEventListener('DOMContentLoaded', () => {
    console.log("Chart initialized");
     if (isChartInitialized) return;  // 🔒 防止重复执行
    isChartInitialized = true;
    let ctx = document.getElementById('activityChart').getContext('2d');
    
    // 检查 ctx 是否为 null，如果为 null 则不尝试创建图表，并在控制台报错
    if (!ctx) {
        console.error("Canvas element with ID 'activityChart' not found or context could not be obtained.");
        return; // 提前退出，避免后续错误
    }
    if (chart) {
        chart.destroy();
    }
    // 初始化 chart 实例
    // 这里不需要 chart.destroy()，因为DOMContentLoaded只执行一次，不会重复创建
    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: '活动时长 (小时)',
                data: [],
                backgroundColor: [],
                borderColor: 'black',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true },
                x: {}
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 使用从 PHP 传递的 initialActivities 数据初始化图表
    // 确保 initialActivities 在 script.js 之前被定义 (在 dashboard.php 中)
    if (typeof initialActivities !== 'undefined' && initialActivities.length > 0) {
        chart.data.labels = initialActivities.map(d => d.Category);
        chart.data.datasets[0].data = initialActivities.map(d => Number(d.TotalHours));
        chart.data.datasets[0].backgroundColor = initialActivities.map(d => categoryColors[d.Category] || "gray");
        chart.update(); // 更新图表数据
    }
});

function updateChart() {
    let startDate = document.getElementById('startDate').value;
    let endDate = document.getElementById('endDate').value;
    const groupType = document.getElementById('groupType').value;
    // fetch 请求路径依然使用绝对路径
    fetch(`/TimeTracker/controllers/getData.php?start=${startDate}&end=${endDate}&group=${groupType}`)
        .then(response => {
            // 添加错误处理，检查 HTTP 响应状态
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // 确保 chart 实例已经存在才进行更新
            if (chart) {
                 // 清空旧数据
                chart.data.labels = [];
                chart.data.datasets = [];
                // 按分组类型处理数据
                if (groupType && groupType !== '') {
                    // 时间分组模式 - 使用分组柱状图
                    const timeGroups = [...new Set(data.map(d => d.Label))];
                    const categories = [...new Set(data.map(d => d.Category))];
                    
                    // 为每个类别创建一个数据集
                categories.forEach(category => {
                        const categoryData = timeGroups.map(time => {
                            const item = data.find(d => d.Label === time && d.Category === category);
                            return item ? Number(item.TotalHours) : 0;
                        });
                        
                        chart.data.datasets.push({
                            label: category,
                            data: categoryData,
                            backgroundColor: categoryColors[category] || "gray",
                            borderColor: 'black',
                            borderWidth: 1
                        });
                    });
                    
                    chart.data.labels = timeGroups;
                } else {
                    // 默认模式 - 按类别分组
                    chart.data.labels = data.map(d => d.Label);
                    chart.data.datasets = [{
                        label: '活动时长 (小时)',
                        data: data.map(d => Number(d.TotalHours)),
                        backgroundColor: data.map(d => categoryColors[d.Label] || "gray"),
                        borderColor: 'black',
                        borderWidth: 1
                    }];
                }
                
                // 更新图表配置
                chart.options.scales.x = {
                    stacked: groupType && groupType !== '',
                };
                chart.options.scales.y = {
                    beginAtZero: true,
                    stacked: groupType && groupType !== '',
                };
                chart.options.plugins.legend = {
                    display: groupType && groupType !== '',
                };
                
                chart.update();
                
            } else {
                console.error("在调用 updateChart 时，图表实例未初始化。");
            }
        })
        .catch(error => console.error('Error in updateChart:', error));
}