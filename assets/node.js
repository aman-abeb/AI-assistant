const { GoogleGenerativeAI } = require("@google/generative-ai");

const generateContent = async (prompt) => {
    const genAI = new GoogleGenerativeAI("AIzaSyA_YFnZy9YDYJIS3mdI1X_RgTfzq5VdLmc");
    const model = genAI.getGenerativeModel({ model: "gemini-1.0-pro" });

    try {
        const result = await model.generateContent(prompt);
        console.log(result.response.text()); // Output the result to standard output
    } catch (error) {
        console.error('Error generating content:', error);
    }
};

const prompt = process.argv[2];
generateContent(prompt);