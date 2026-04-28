<style>
    .custom-box {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
    }

    .box-title {
        font-size: 18px;
        font-weight: 600;
        color: #0053a1;
        margin-bottom: 16px;
        border-bottom: 2px solid #0053a1;
        padding-bottom: 5px;
    }

    .sub-permits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 12px 20px;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .sub-permits-grid li {
        background: #e8f0fa;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 500;
        color: #0053a1;
        box-shadow: 0 2px 5px rgba(0, 83, 161, 0.1);
        transition: all 0.3s ease;
    }

    .sub-permits-grid li:hover {
        background: #d0e7fc;
        transform: scale(1.02);
    }

    .breadcrumb-steps {
        position: relative;
        display: flex;
        flex-wrap: nowrap;
        list-style: none;
        padding: 0;
        margin: 0;
        counter-reset: step;
        gap: 20px;
        overflow-x: auto;

        transition: transform 0.3s ease;
    }

    .breadcrumb-steps li {
        position: relative;
        background: linear-gradient(to right, #0053a1, #0077d0);
        color: #fff;
        padding: 6px 18px 6px 28px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        flex-shrink: 0;
        width: 200px;
        text-wrap: wrap;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;

        white-space: normal;
        word-break: break-word;
        min-height: 60px;
        padding-left: 30px;

        margin-bottom: 10px;
        scrollbar-gutter: stable both-edges;
    }

    .breadcrumb-steps li::before {
        content: counter(step);
        counter-increment: step;
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: #fff;
        color: #0053a1;
        font-weight: bold;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .breadcrumb-steps li:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 100%;
        transform: translateY(-50%);
        margin-left: 4px;
        width: 0;
        height: 0;
        border-top: 6px solid transparent;
        border-bottom: 6px solid transparent;
        border-left: 10px solid #0077d0;
    }

    .breadcrumb-steps li:last-child::after {
        content: none;
    }

    .breadcrumb-steps::-webkit-scrollbar {
        height: 6px;
    }

    .breadcrumb-steps::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .breadcrumb-steps::-webkit-scrollbar-thumb {
        background: #0077d0;
        border-radius: 10px;
    }

    .breadcrumb-steps::-webkit-scrollbar-thumb:hover {
        background: #0053a1;
    }


    @media (max-width: 576px) {
        .sub-permits-grid {
            grid-template-columns: 1fr;
        }

        .breadcrumb-steps {
            flex-direction: column;
            gap: 12px;
        }

        .breadcrumb-steps li:not(:last-child)::after {
            content: none;
        }

        .breadcrumb-steps li {
            white-space: normal;
            word-break: break-word;
            min-height: 60px;
            padding-left: 30px;
            /* ensure space for the step counter */
        }
    }

    @keyframes rubber-band-left {
        0% {
            transform: translateX(0);
        }

        30% {
            transform: translateX(15px);
        }

        60% {
            transform: translateX(-10px);
        }

        100% {
            transform: translateX(0);
        }
    }

    @keyframes rubber-band-right {
        0% {
            transform: translateX(0);
        }

        30% {
            transform: translateX(-15px);
        }

        60% {
            transform: translateX(10px);
        }

        100% {
            transform: translateX(0);
        }
    }

    .breadcrumb-steps.rubber-left {
        animation: rubber-band-left 0.5s ease;
    }

    .breadcrumb-steps.rubber-right {
        animation: rubber-band-right 0.5s ease;
    }
</style>

<!-- Breadcrumb Steps Box -->
<div class="custom-box">
    <div class="box-title">PTW Workflow</div>
    <ul class="breadcrumb-steps">
        <li>General PTW Apply by Contractor Applicant</li>
        <li>Sub Permit(s) Approval by Corresponding Certificate Authority</li>
        <li>Area Owner Approval based on Location</li>
        <li>GHSSE Approval</li>
        <li>Supervising Authority Approval Based on Work Type</li>
        <li>Active PTW</li>
        <li>Freeze/Unfeeze by GHSSE if any Violation</li>
        <li>Close PTW by Applicant</li>
    </ul>
</div>


<script>
    const container = document.querySelector(".breadcrumb-steps");

    container.addEventListener("scroll", function() {
        const scrollLeft = container.scrollLeft;
        const maxScrollLeft = container.scrollWidth - container.clientWidth;

        if (scrollLeft === 0) {
            triggerRubber(container, "left");
        } else if (Math.ceil(scrollLeft) >= maxScrollLeft) {
            triggerRubber(container, "right");
        }
    });

    function triggerRubber(container, direction) {
        const className = direction === "left" ? "rubber-left" : "rubber-right";

        // Remove if already applied
        container.classList.remove(className);

        // Reflow to re-trigger animation
        void container.offsetWidth;

        // Apply class
        container.classList.add(className);

        // Remove after animation completes
        setTimeout(() => {
            container.classList.remove(className);
        }, 500);
    }
</script>
