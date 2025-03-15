const diveLinker = new DiveLinker("dive");

window.onload = function () {
    diveLinker.enableBlock(false);
    diveLinker.start();
};

let username;
let password;
let login = 0;
let login_fail;
let no_login;

// 預設的正確帳密存於 JSON 檔案（假設為 users.json）
const jsonFile = 'users.json';

// 每秒檢查登入狀態
setInterval(() => {
    // 更新 DiveLinker 屬性
    username = diveLinker.getAttr("3684d51accdd4e21b742ed50c2eb131c");
    password = diveLinker.getAttr("dc692c9c120546bd8d48240facd8bef3");
    login = diveLinker.getAttr("d36dab8ddc874d9b868b29d7950ef482");
    login_fail = diveLinker.getAttr("9ca1343412b247e994fb00a75ecaa43f");
    no_login = diveLinker.getAttr("c9d6811c63644917bd31342551e5a1b8");

    // 動態更新顯示的內容
    if (document.getElementById("dynamicText00")) {
        document.getElementById("dynamicText00").innerHTML = `這是更新後的 username: ${username}`;
    }
    if (document.getElementById("dynamicText01")) {
        document.getElementById("dynamicText01").innerHTML = `這是更新後的 password: ${password}`;
    }
    if (document.getElementById("dynamicText02")) {
        document.getElementById("dynamicText02").innerHTML = `這是更新後的 login: ${login}`;
    }
    if (document.getElementById("dynamicText03")) {
        document.getElementById("dynamicText03").innerHTML = `這是更新後的 login_fail: ${login_fail}`;
    }
    if (document.getElementById("dynamicText04")) {
        document.getElementById("dynamicText04").innerHTML = `這是更新後的 no_login123: ${no_login}`;
    }

    // 自動填入帳密到表單
    if (document.getElementById("username") && document.getElementById("password")) {
        document.getElementById("username").value = username ; // 如果 username 為空，則設置為空字符串
        document.getElementById("password").value = password ; // 如果 password 為空，則設置為空字符串
    }

    // 檢查是否觸發登入驗證
    if (login == 1) {
        fetch(jsonFile)
            .then(response => {
                if (!response.ok) {
                    throw new Error("無法載入 JSON 檔案");
                }
                return response.json();
            })
            .then(data => {
                const users = data.users;
                const user = users.find(u => u.username === username && u.password === password);
                localStorage.setItem("username", username); // 儲存登入狀態
                if (user) {
                    // 登入成功
                    document.getElementById("errorMessage").textContent = `成功登入`;
                    localStorage.setItem("username", username); // 儲存登入狀態
                    setTimeout(() => {
                        window.location.href = 'index.html'; // 跳轉到 index.html
                    }, 1000); // 延遲跳轉，讓使用者看到成功訊息
                } else {
                    // 登入失敗
                    document.getElementById("errorMessage").textContent = `登入失敗，請檢查您的使用者名稱或密碼`;
                    diveLinker.setInput("9ca1343412b247e994fb00a75ecaa43f", 1); // 更新失敗狀態
                }
            })
            .catch(error => {
                console.error("錯誤:", error);
                document.getElementById("errorMessage").textContent = `系統錯誤，請稍後再試`;
            });
    }

    // 無登入處理
    if (no_login == 1) {
        window.location.href = "https://kalemau.synology.me:50443/CAPD07/index.html";
    }
}, 1000);
