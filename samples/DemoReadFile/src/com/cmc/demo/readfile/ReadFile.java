package com.cmc.demo.readfile;
import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Scanner;

public class ReadFile {

	public static void main(String[] args) {
		Scanner sc = null;
		ArrayList<String> list = new ArrayList<String>();
		try {
			sc = new Scanner(new File("src\\account.txt"));
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
		while (sc.hasNextLine()) {
			String account = null;
			account = sc.nextLine();
			account.trim();
			list.add(account);
		}
		System.out.print(list);
	}
}
